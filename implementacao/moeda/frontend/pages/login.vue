<template>
    <v-main>
        <v-container fluid fill-height>
            <v-layout align-center justify-center>
                <v-flex xs12 sm8 md4>
                    <v-card class="elevation-12">
                        <v-toolbar dark color="primary">
                            <v-toolbar-title>Login</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-form>
                                <v-text-field
                                    prepend-icon="mdi-account"
                                    v-model="formData.email"
                                    name="email"
                                    label="Email"
                                    type="text"
                                ></v-text-field>
                                <v-text-field
                                    prepend-icon="mdi-lock"
                                    v-model="formData.password"
                                    :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                    :rules="[rules.required]"
                                    :type="show1 ? 'text' : 'password'"
                                    label="SENHA"
                                    @click:append="show1 = !show1"
                                    @keypress.enter="realizarLogin"
                                ></v-text-field>
                            </v-form>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn color="primary" block @click="realizarLogin">Login</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-flex>
            </v-layout>
        </v-container>
    </v-main>
</template>
<script>
export default {
    layout: "main",

    /*SENHA*/
    data() {
        return {
            show1: false,
            dialog: false,
            formData: {
                email: null,
                password: null
            },
            rules: {
                required: value => !!value || "Obrigatório!"
            }
        };
    },
    methods: {
        realizarLogin() {
            this.$axios
                .post("/login", this.formData)
                .then(res => {
                    this.$store.dispatch('login/userLogin', {
                        loginData: res.data.token,
                        router: this.$router,
                        axios: this.$axios
                    })
                })
                .catch(err => {
                    console.log(err)
                    alert(err.response.data.message, 'Erro', { type: 'error', msgBody: { style: { width: '30%' } } })
                });
        }
    }
};
</script>