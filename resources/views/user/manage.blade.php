@extends('template.layout')

@section('content')

<v-container fluid>
    <v-row>
        <v-col md="6">
            <h2>User Management</h2>
        </v-col>
        <v-spacer></v-spacer>
        <v-col md="2" offset-md="4">
            <v-btn large  @click.stop="createDialog = true">Add User</v-btn>
        </v-col>
    </v-row>
    <v-data-table
        :headers="headers"
        disable-pagination
        disable-sort
        :items="items">
        <template v-slot:item.action="{ item }">
            <v-btn small @click="edit(item)">Edit</v-btn>
        </template>
    </v-data-table>
</v-container>

<v-dialog v-model="createDialog" persistent max-width="600px">
    <v-form ref="addForm" @submit.prevent="save">
        <v-card>
            <v-card-title>
                <span class="headline">Add User</span>
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
                                label="Username"
                                v-model="username"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                label="Name"
                                v-model="name"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                label="Email Address"
                                v-model="email"
                                :rules="emailRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                type="password"
                                label="Password"
                                v-model="password"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-autocomplete
                                outlined
                                label="Role"
                                v-model="role"
                                :items="roleItems"
                                item-text="name"
                                item-value="id"
                                :rules="fieldRules"
                            ></v-autocomplete>
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
    <v-form ref="editForm" @submit.prevent="update">
        <v-card>
            <v-card-title>
                <span class="headline">Edit User</span>
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
                                label="Username"
                                v-model="username"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                label="Name"
                                v-model="name"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-text-field
                                outlined
                                label="Email Address"
                                v-model="email"
                                :rules="emailRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-autocomplete
                                outlined
                                label="Role"
                                v-model="role"
                                :items="roleItems"
                                item-text="name"
                                item-value="id"
                                :rules="fieldRules"
                            ></v-autocomplete>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-btn color="blue darken-1" text @click="deleteData">Delete</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
                <v-btn color="blue darken-1" text type="submit">Edit</v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</v-dialog>

{{-- <v-dialog v-model="editDialog" max-width="600px">
        <v-form ref="editForm" @submit.prevent="update">
            <v-card>
                <v-card-title>
                    <span class="headline">Edit User</span>
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
                                    label="Username"
                                    v-model="username"
                                    :rules="fieldRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    outlined
                                    label="Email Address"
                                    v-model="email"
                                    :rules="fieldRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    outlined
                                    label="Password"
                                    v-model="password"
                                    :rules="fieldRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    outlined
                                    label="Role"
                                    v-model="role"
                                    :rules="fieldRules"
                                ></v-text-field>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="blue darken-1" text @click="delete">Delete</v-btn>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
                    <v-btn color="blue darken-1" text type="submit">Edit</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-dialog> --}}

<script>
    var user = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            createDialog: false,
            editDialog: false,
            username: null,
            name: null,
            email: null,
            password: null,
            userId: null,
            role: null,
            indexItem: null,
            error: false,
            fieldRules: [
                v => !!v || 'This field is required.'
            ],
            emailRules: [
                v => !!v || 'This field is required.',
                v => /.+@.+\..+/.test(v) || 'E-mail must be valid.',
            ],
            headers: [
                { text: 'Username', value: 'username' },
                { text: 'Name', value: 'name' },
                { text: 'Email Address', value: 'email' },
                { text: 'Role', value: 'role.name' },
                { text: 'Created at', value: 'created_at' },
                { text: 'Action', value: 'action' }
            ],
            items: [],
            roleItems: []
        }),
        created: function() {
            this.getData();
            this.getRoles();
        },
        methods: {
            save() {
                if(this.$refs.addForm.validate()) {
                    var config = {
                        username: this.username,
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        role: this.role,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/user/manage/add") }}', config)
                        .then(res => {
                            console.log(res);
                            this.items.push({
                                id: res.body.last_id,
                                username: this.username, 
                                name: this.name,
                                email: this.email,
                                role: { name:res.body.role_name, id:res.body.role_id },
                                created_at: res.body.created_at.date
                            });
                            this.closeDialog();
                            this.error = false;
                        }, err => {
                            console.log(err);
                            this.error = true;
                    })
                }
            },
            getData() {
                this.$http.get('{{ url("/user/manage/get") }}')
                    .then(res => {
                        console.log(res);
                        var data = res.body;
                        this.items = res.body;
                    }, err => {
                        console.log(err);
                    })
            },
            getRoles() {
                this.$http.get('{{ url("/user/role/get") }}')
                    .then(res => {
                        console.log(res);
                        var data = res.body;
                        this.roleItems = res.body;
                    }, err => {
                        console.log(err);
                    })
            },
            edit(item) {
                this.editDialog = true;
                console.log(this.items.indexOf(item));
                this.username = item.username,
                this.name = item.name,
                this.email = item.email,
                this.userId = item.id,
                this.role = item.role.id,
                this.indexItem = this.items.indexOf(item);
            },
            deleteData() {
                var config = {
                    id: this.userId,
                    _token: "{{ csrf_token() }}"
                }
                this.$http.post('{{ url("/user/manage/delete") }}', config)
                    .then(res => {
                        this.items.splice(this.indexItem, 1)
                        this.closeDialog();
                        this.error = false;
                    }, err => {
                        console.log(err);
                        this.error = true;
                })
            },
            update() {

                if(this.$refs.editForm) {
                    var config = {
                        id: this.userId,
                        username: this.username,
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        role: this.role,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/user/manage/edit") }}', config)
                        .then(res => {
                            console.log(res);
                            var newItem = {
                                id: this.userId,
                                username: this.username, 
                                name: this.name,
                                email: this.email,
                                role: { name:res.body.role_name, id:res.body.role_id },
                            }
                            Object.assign(this.items[this.indexItem], newItem);
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
                this.$refs.addForm.reset();
                this.$refs.editForm.reset();
                this.error = false;
                this.username = null;
                this.name = null;
                this.email = null;
                this.password = null;
                this.userId = null;
                this.role = null;
                this.indexItem = null;
            }
        }
    })
</script>

@endsection