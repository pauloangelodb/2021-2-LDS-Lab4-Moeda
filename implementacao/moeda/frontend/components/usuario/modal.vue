<template>
    <div class="text-center">
        <v-dialog
            v-model="value"
            scrollable
            max-width="500px"
            transition="dialog-bottom-transition"
            class="usuario-modal"
            @click:outside="$emit('input', false)"
            @keydown.esc="$emit('input', false)"
        >
            <v-card>
                <v-card-title class="text-h5 usuario-modal-title">
                    <h4>
                        <span>{{ titulo }}</span>
                    </h4>
                    <v-btn icon @click="$emit('input', false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-form ref="formusuario" v-model="valid" lazy-validation>
                            <!-- Identificação -->
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="usuario.name"
                                        hide-details="auto"
                                        label="Nome"
                                        :rules="[v => !!v || 'Nome é obrigatório']"
                                        maxlength="100"
                                        outlined
                                    />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="usuario.email"
                                        hide-details="auto"
                                        label="Email"
                                        :rules="[v => !!v || 'Email é obrigatório']"
                                        maxlength="200"
                                        outlined
                                    />
                                </v-col>
                            </v-row>
                            <v-row>                            
                                <v-col cols="12" sm="12" class="mt-n2">
                                    <v-text-field
                                        v-model="usuario.password"
                                        :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
                                        :rules="[v => !!v || 'Senha é obrigatório']"
                                        :type="show1 ? 'text' : 'password'"
                                        label="Senha"
                                        @click:append="show1 = !show1"
                                        outlined
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-row>                            
                                <v-col cols="12" sm="12" class="mt-n2">
                                    <v-select                                        
                                        v-model="usuario.tipo"                                        
                                        :items="tipos"
                                        item-text="nome"
                                        item-value="value"
                                        :rules="[v => !!v || 'Tipo é obrigatório']"                                        
                                        label="Tipo"                                        
                                        outlined
                                    ></v-select>
                                </v-col>
                            </v-row>

<!-- 
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="usuario.documento"
                                        hide-details="auto"
                                        label="Documento"
                                        :rules="[v => !!v || 'Documento é obrigatório']"
                                        maxlength="30"
                                        outlined
                                    />
                                </v-col>
                            </v-row> -->


                            <!-- Botão de marcarConsulta -->
                            <v-row>
                                <v-col class="usuario-modal-marcar text-center">
                                    <v-btn color="primary" block @click="gravar">Gravar</v-btn>
                                </v-col>
                            </v-row>
                        </v-form>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
export default {
    name: "modal-usuario",
    props: ["value", "usuarioId"],
    data() {
        return {
            valid: true,
            titulo: "Novo usuario",
            show1: false,

            tipos: [{nome:"Aluno", value:"ALUNO"}, {nome:"Professor", value:"P"}],

            usuario: {
                id: '',
                name: '',
                password: '',
                email: '',
                tipo:''
            },
            cursos: [{ nome: "", id: 0 }],
            instituicaos: [{ nome: "", id: 0 }],
        };
    },
    watch: {
        value: function () {
            // this.$axios
            //     .$get("/curso")
            //     .then((response) => { this.cursos = response })
            //     .catch((error) => {
            //         this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });

            //     });

            // this.$axios
            //     .$get("/instituicao")
            //     .then((response) => { this.instituicaos = response })
            //     .catch((error) => {
            //         this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });

            //     });
        },
        usuarioId: function (id) {
            if (id != 0) {
                this.edit(id);
                this.titulo = "Editar usuario"
            } else {
                this.titulo = "Novo usuario"
                this.limpaDados();
            }
        },
    },
    methods: {
        gravar() {
            if (this.$refs.formusuario.validate()) {
                let usuario = JSON.parse(JSON.stringify(this.usuario));

                if (usuario.id == 0) {
                    this.$axios
                        .$post("/usuario", usuario)
                        .then((response) => {
                            this.limpaDados();
                            this.$swal( "usuario adicionado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listausuarios')

                        })
                        .catch((error) => {
                            this.abreToast(error);
                        });
                } else {
                    this.$axios
                        .$put("/usuario/" + usuario.id, usuario)
                        .then((response) => {
                            this.edit(usuario.id);
                            this.$swal( "usuario atualizado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listausuarios')
                        })
                        .catch((error) => {
                            this.abreToast(error);
                        });
                }

            }
        },

        edit(id) {
            this.$axios
                .$get("/usuario/" + id)
                .then((response) => {
                    this.usuario = response;
                })
                .catch((error) => {
                    console.log(error);
                });

        },

        limpaDados() {
            this.usuario = {
                id: '',
                nome: '',
                documento: '',
                curso_id: '',
                instituicao_id:''
            }
            this.$refs.formusuario.reset();
        },

    },
};
</script>

<style>
.usuario-modal-title {
    margin-left: 20px;
}

.usuario-modal-title h4 {
    width: calc(100% - 50px);
    text-align: left;
    border-bottom: 1px solid #b7b7b7;
    line-height: 0.1em;
    margin: 20px 0 20px;
}

.usuario-modal-title h4 span {
    padding: 0 5px;
}

.usuario-modal-marcar {
    border-radius: 10px;
}
</style>
