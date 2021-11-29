<template>
    <div class="text-center">
        <v-dialog
            v-model="value"
            scrollable
            max-width="500px"
            transition="dialog-bottom-transition"
            class="empresa-modal"
            @click:outside="$emit('input', false)"
            @keydown.esc="$emit('input', false)"
        >
            <v-card>
                <v-card-title class="text-h5 empresa-modal-title">
                    <h4>
                        <span>{{ titulo }}</span>
                    </h4>
                    <v-btn icon @click="$emit('input', false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-form ref="formEmpresa" v-model="valid" lazy-validation>
                            <!-- Identificação -->
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="empresa.nome"
                                        hide-details="auto"
                                        label="Nome"
                                        :rules="[v => !!v || 'Nome é obrigatório']"
                                        maxlength="30"
                                        outlined
                                    />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="empresa.documento"
                                        hide-details="auto"
                                        label="Documento"
                                        :rules="[v => !!v || 'Documento é obrigatório']"
                                        maxlength="30"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <!-- Botão de marcarConsulta -->
                            <v-row>
                                <v-col class="empresa-modal-marcar text-center">
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
    name: "modal-empresa",
    props: ["value", "empresaId"],
    data() {
        return {
            valid: true,
            titulo: "Novo empresa",

            empresa: {
                id: '',
                nome: '',
                documento: '',

            },
        };
    },
    watch: {
        empresaId: function (id) {
            if (id != 0) {
                this.edit(id);
                this.titulo = "Editar empresa"
            } else {
                this.titulo = "Novo empresa"
                this.limpaDados();
            }
        },
    },
    methods: {
        gravar() {
            if (this.$refs.formEmpresa.validate()) {
                let empresa = JSON.parse(JSON.stringify(this.empresa));

                if (empresa.id == 0) {
                    this.$axios
                        .$post("/empresa", empresa)
                        .then((response) => {
                            this.limpaDados();
                            this.$emit('abreToast', "empresa adicionado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listaEmpresas')

                        })
                        .catch((error) => {
                            this.abreToast(error);
                        });
                } else {
                    this.$axios
                        .$put("/empresa/" + empresa.id, empresa)
                        .then((response) => {
                            this.edit(empresa.id);
                            this.$emit('abreToast', "empresa atualizado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listaEmpresas')
                        })
                        .catch((error) => {
                            this.abreToast(error);
                        });
                }

            }
        },

        edit(id) {
            this.$axios
                .$get("/empresa/" + id)
                .then((response) => {
                    this.empresa = response;
                })
                .catch((error) => {
                    console.log(error);
                });

        },

        limpaDados() {
            this.empresa = {
                id: '',
                nome: '',
                documento: '',
                curso_id: '',
                instituicao_id:''
            }
            this.$refs.formEmpresa.reset();
        },

    },
};
</script>

<style>
.empresa-modal-title {
    margin-left: 20px;
}

.empresa-modal-title h4 {
    width: calc(100% - 50px);
    text-align: left;
    border-bottom: 1px solid #b7b7b7;
    line-height: 0.1em;
    margin: 20px 0 20px;
}

.empresa-modal-title h4 span {
    padding: 0 5px;
}

.empresa-modal-marcar {
    border-radius: 10px;
}
</style>
