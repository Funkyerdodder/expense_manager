@extends('template.layout')

@section('content')

<v-container fluid>
    <v-row>
        <v-col md="6">
            <h2>Expense Management</h2>
        </v-col>
        <v-spacer></v-spacer>
        <v-col md="2" offset-md="4">
            <v-btn large  @click.stop="createDialog = true">Add Expense</v-btn>
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
                <span class="headline">Add Expenses</span>
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
                                label="Amount"
                                v-model="amount"
                                type="number"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-menu
                                v-model="menuPicker"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px">
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        outlined
                                        v-model="date"
                                        label="Date"
                                        readonly
                                        v-on="on">
                                    </v-text-field>
                                </template>
                                <v-date-picker 
                                    color="teal darken-3"
                                    v-model="date" 
                                    :max="moment().format('YYYY-MM-DD')"
                                    @input="menuPicker = false">
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-autocomplete
                                outlined
                                label="Category"
                                v-model="category"
                                :items="categoryItems"
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
                                label="Amount"
                                v-model="amount"
                                type="number"
                                :rules="fieldRules"
                            ></v-text-field>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-menu
                                v-model="menuPicker"
                                :close-on-content-click="false"
                                :nudge-right="40"
                                transition="scale-transition"
                                offset-y
                                min-width="290px">
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                        outlined
                                        v-model="date"
                                        label="Date"
                                        readonly
                                        v-on="on">
                                    </v-text-field>
                                </template>
                                <v-date-picker 
                                    color="teal darken-3"
                                    v-model="date" 
                                    :max="moment().format('YYYY-MM-DD')"
                                    @input="menuPicker = false">
                                </v-date-picker>
                            </v-menu>
                        </v-col>
                    </v-row>
                    <v-row>
                        <v-col>
                            <v-autocomplete
                                outlined
                                label="Category"
                                v-model="category"
                                :items="categoryItems"
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

<script>
    var user = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data: () => ({
            createDialog: false,
            editDialog: false,
            expenseId: null,
            amount: null,
            date: null,
            category: null,
            indexItem: null,
            menuPicker: false,
            error: false,
            fieldRules: [
                v => !!v || 'This field is required.'
            ],
            headers: [
                { text: 'Category', value: 'category.name' },
                { text: 'Amount', value: 'amount' },
                { text: 'Entry Date', value: 'date' },
                { text: 'Created at', value: 'created_at' },
                { text: 'Action', value: 'action' }
            ],
            items: [],
            categoryItems: []
        }),
        created: function() {
            this.getData();
            this.getCategory();
        },
        methods: {
            save() {
                if(this.$refs.addForm.validate()) {
                    var config = {
                        amount: this.amount,
                        date: this.date,
                        category: this.category,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/expense/manage/add") }}', config)
                        .then(res => {
                            console.log(res);
                            this.items.push({
                                id: res.body.last_id,
                                amount: this.amount, 
                                date: this.date,
                                category: { id: res.body.category_id, name: res.body.category_name },
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
                this.$http.get('{{ url("/expense/manage/get") }}')
                    .then(res => {
                        console.log(res);
                        var data = res.body.expenses;
                        this.items = data;
                    }, err => {
                        console.log(err);
                    })
            },
            getCategory() {
                this.$http.get('{{ url("/expense/categories/get") }}')
                    .then(res => {
                        console.log(res);
                        var data = res.body;
                        this.categoryItems = res.body;
                    }, err => {
                        console.log(err);
                    })
            },
            edit(item) {
                this.editDialog = true;
                console.log(item);
                this.expenseId = item.id;
                this.amount = item.amount;
                this.date = item.date;
                this.category = item.category.id;
                // this.username = item.username,
                // this.name = item.name,
                // this.email = item.email,
                // this.userId = item.id,
                // this.role = item.role.id,
                this.indexItem = this.items.indexOf(item);
            },
            deleteData() {
                var config = {
                    id: this.expenseId,
                    _token: "{{ csrf_token() }}"
                }
                this.$http.post('{{ url("/expense/manage/delete") }}', config)
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
                        id: this.expenseId,
                        amount: this.amount,
                        date: this.date,
                        category: this.category,
                        _token: "{{ csrf_token() }}"
                    }
                    this.$http.post('{{ url("/expense/manage/update") }}', config)
                        .then(res => {
                            console.log(res);
                            var newItem = {
                                id: this.expenseId,
                                amount: this.amount, 
                                date: this.date,
                                email: this.email,
                                category: { name:res.body.category_name, id:res.body.category_id },
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
                this.expenseId = null;
                this.amount = null;
                this.date = null;
                this.category = null;
                this.indexItem = null;
            }
        }
    })
</script>

@endsection