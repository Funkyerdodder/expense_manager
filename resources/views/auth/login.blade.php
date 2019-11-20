@extends('template.login-layout')

@section('content')
<div id="login">
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row justify="center">
                    <v-col cols="6">
                        <v-card>
                            <v-card-title class="justify-center teal lighten-1">
                                Login
                            </v-card-title>
                            <v-divider></v-divider>
                            <v-form @submit.prevent="login" ref="loginForm">
                                <v-container>
                                    <v-alert type="error" dismissible v-if="error">
                                        @{{ errMsg }}
                                    </v-alert>  
                                    <v-row>
                                        <v-col>
                                            <v-text-field 
                                                outlined
                                                required
                                                v-model="username"
                                                :rules="fieldRules"
                                                label="Username">
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col>
                                            <v-text-field 
                                                type="password"
                                                required
                                                v-model="password"
                                                outlined
                                                :rules="fieldRules"
                                                label="Password">
                                            </v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row justify="center">
                                        <v-btn type="submit" class="teal lighten-1">Sign in</v-btn>
                                    </v-row>
                                </v-container>
                            </v-form>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</div>

<script>
    var login = new Vue({
        el: '#login',
        vuetify: new Vuetify(),
        data: () => ({
            username: null,
            password: null,
            error: false,
            errMsg: null,
            fieldRules: [
                v => !!v || 'This field is required.'
            ]
        }),
        methods: {
            login() {
                var config = {
                    _token: '{{ csrf_token() }}',
                    username: this.username,
                    password: this.password
                };
                if(this.$refs.loginForm.validate()) {
                    this.$http.post('{{ route('login') }}', config)
                        .then(response => {
                            var data = response.body;
                            if(data.status === 'successful') {
                                window.location.replace("{{ route('dashboard') }}")
                            } else {
                                this.error = true;
                                this.errMsg = data.status
                            }
                        }, err => {
                            var msg = err.body.errors;
                            console.log(msg);
                        })
                }
            }
        }
    });
</script>
@endsection

