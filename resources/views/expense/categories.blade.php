@extends('template.layout')

@section('content')

<v-container fluid>
    <v-row>
        <v-col md="6">
            <h2>Expense Category</h2>
        </v-col>
        <v-spacer></v-spacer>
        <v-col md="2" offset-md="4">
            <v-btn large  @click.stop="createDialog = true">Add Category</v-btn>
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
                                label="Category"
                                v-model="name"
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
    <v-form ref="editForm" @submit.prevent="update">
        <v-card>
            <v-card-title>
                <span class="headline">Edit Category</span>
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
                                label="Category"
                                v-model="name"
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
                <v-btn color="blue darken-1" text @click="deleteData">Delete</v-btn>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDialog">Close</v-btn>
                <v-btn color="blue darken-1" text type="submit">Edit</v-btn>
            </v-card-actions>
        </v-card>
    </v-form>
</v-dialog>

<script>
    var user = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            createDialog: false,
            editDialog: false,
            categoryId: null,
            name: null,
            description: null,
            indexItem: null,
            error: false,
            fieldRules: [
                v => !!v || 'This field is required.'
            ],
            headers: [
                { text: 'Category', value: 'name' },
                { text: 'Description', value: 'description' },
                { text: 'Created at', value: 'created_at' },
                { text: 'Action', value: 'action' }
            ],
            items: [],
        }),
        created: function() {
            this.getData();
        },
        methods: {
            save() {
                if(this.$refs.addForm.validate()) {
                    var config = {
                        name: this.name,
                        description: this.description,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/expense/categories/add") }}', config)
                        .then(res => {
                            console.log(res);
                            this.items.push({
                                id: res.body.last_id,
                                name: this.name,
                                description: this.description,
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
                this.$http.get('{{ url("/expense/categories/get") }}')
                    .then(res => {
                        console.log(res);
                        var data = res.body;
                        this.items = res.body;
                    }, err => {
                        console.log(err);
                    })
            },
            edit(item) {
                this.editDialog = true;
                console.log(this.items.indexOf(item));
                this.categoryId = item.id;
                this.name = item.name;
                this.description = item.description;
                this.indexItem = this.items.indexOf(item);
            },
            deleteData() {
                var config = {
                    id: this.categoryId,
                    _token: "{{ csrf_token() }}"
                }
                this.$http.post('{{ url("/expense/categories/delete") }}', config)
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
                        id: this.categoryId,
                        name: this.name,
                        description: this.description,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/expense/categories/update") }}', config)
                        .then(res => {
                            console.log(res);
                            var newItem = {
                                id: this.categoryId,
                                name: this.name,
                                description: this.description,
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
                this.categoryId = null;
                this.name = null;
                this.description = null;
                this.indexItem = null;
                this.error = false;
            }
        }
    })
</script>

@endsection