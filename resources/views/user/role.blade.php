@extends('template.layout')

@section('content')

<v-container fluid>
    <v-row>
        <v-col md="6">
            <h2>Roles</h2>
        </v-col>
        <v-spacer></v-spacer>
        <v-col md="2" offset-md="4">
            <v-btn large  @click.stop="createDialog = true">Add Role</v-btn>
        </v-col>
    </v-row>
    <v-data-table
        :headers="headers"
        disable-pagination
        disable-sort
        :items="roles">
        <template v-slot:item.action="{ item }">
            <v-btn small @click="editItem(item)">Edit</v-btn>
        </template>
    </v-data-table>
</v-container>

<v-dialog v-model="createDialog" persistent max-width="600px">
    <v-form ref="roleForm" @submit.prevent="saveRole">
        <v-card>
            <v-card-title>
                <span class="headline">Add Role</span>
            </v-card-title>
            <v-divider></v-divider>
            <v-card-text>
                <v-container>
                    <v-alert type="error" dismissible v-if="error">
                        An error occured while saving.
                    </v-alert>  
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                label="Display Name"
                                v-model="roleName"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                label="Description"
                                v-model="description"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
                <v-btn color="blue darken-1" text type="submit">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</v-dialog>

<v-dialog v-model="editDialog" persistent max-width="600px">
        <v-form ref="editRoleForm" @submit.prevent="editRole">
            <v-card>
                <v-card-title>
                    <span class="headline">Edit Role</span>
                </v-card-title>
                <v-divider></v-divider>
                <v-card-text>
                    <v-container>
                        <v-alert type="error" dismissible v-if="error">
                            An error occured while saving.
                        </v-alert>  
                        <v-row>
                            <v-col>
                                <v-text-field
                                    outlined
                                    label="Display Name"
                                    v-model="roleName"
                                    :rules="fieldRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    outlined
                                    label="Description"
                                    v-model="description"
                                    :rules="fieldRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="blue darken-1" text @click="deleteRole">Delete</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
                    <v-btn color="blue darken-1" text type="submit">Edit</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog>

<script>
    var dashboard = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            createDialog: false,
            editDialog: false,
            roleName: null,
            roleId: null,
            indexItem: null,
            description: null,
            error: false,
            fieldRules: [
                v => !!v || 'This field is required.'
            ],
            headers: [
                { text: 'Role', value: 'name' },
                { text: 'Description', value: 'description' },
                { text: 'Action', value: 'action' }
            ],
            roles: []
        }),
        created: function() {
            this.getRoles();
        },
        methods: {
            saveRole() {
                if(this.$refs.roleForm.validate()) {
                    var config = {
                        roleName: this.roleName,
                        description: this.description,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/user/role/add") }}', config)
                        .then(res => {
                            this.roles.push({
                                id: res.body.last_id,
                                name: this.roleName, 
                                description: this.description
                            });
                            this.closeDialog();
                            this.error = false;
                        }, err => {
                            console.log(err);
                            this.error = true;
                    })
                }
            },
            getRoles() {
                this.$http.get('{{ url("/user/role/get") }}')
                    .then(res => {
                        console.log(res);
                        var data = res.body;
                        this.roles = res.body;
                    }, err => {
                        console.log(err);
                    })
            },
            editItem(item) {
                this.editDialog = true;
                this.roleName = item.name;
                this.description = item.description;
                this.roleId = item.id;
                this.indexItem = this.roles.indexOf(item);
            },
            deleteRole() {
                var config = {
                    id: this.roleId,
                    _token: "{{ csrf_token() }}"
                }
                this.$http.post('{{ url("/user/role/delete") }}', config)
                    .then(res => {
                        this.roles.splice(this.indexItem, 1)
                        this.closeDialog();
                        this.error = false;
                    }, err => {
                        console.log(err);
                        this.error = true;
                })
            },
            editRole() {

                if(this.$refs.editRoleForm) {
                    var config = {
                        roleName: this.roleName,
                        description: this.description,
                        id: this.roleId,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/user/role/edit") }}', config)
                        .then(res => {
                            var newItem = {
                                name: this.roleName,
                                description: this.description,
                                id: this.roleId
                            }
                            Object.assign(this.roles[this.indexItem], newItem);
                            this.closeDialog();
                            this.error = false;
                        }, err => {
                            console.log(err);
                            this.error = true;
                    })
                }
            },
            closeDialog() {
                this.editDialog = false;
                this.createDialog = false;
                this.roleName = null;
                this.description = null;
                this.roleId = null;
                this.indexItem = null;
                this.$refs.roleForm.reset();
                this.$refs.editRoleForm.reset();
            }
        }
    })
</script>

@endsection