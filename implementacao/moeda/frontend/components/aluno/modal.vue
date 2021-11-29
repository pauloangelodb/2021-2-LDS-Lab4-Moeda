<template>
    <div class="text-center">
        <v-dialog
            v-model="value"
            scrollable
            max-width="500px"
            transition="dialog-bottom-transition"
            class="aluno-modal"
            @click:outside="$emit('input', false)"
            @keydown.esc="$emit('input', false)"
        >
            <v-card>
                <v-card-title class="text-h5 aluno-modal-title">
                    <h4>
                        <span>{{ titulo }}</span>
                    </h4>
                    <v-btn icon @click="$emit('input', false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-form ref="formAluno" v-model="valid" lazy-validation>
                            <!-- Identificação -->
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="aluno.nome"
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
                                        v-model="aluno.documento"
                                        hide-details="auto"
                                        label="Documento"
                                        :rules="[v => !!v || 'Documento é obrigatório']"
                                        maxlength="30"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-select
                                        v-model="aluno.curso_id"
                                        :clearable="true"
                                        hide-details="auto"
                                        label="Curso"
                                        :rules="[(v) => !!v || 'Curso obrigatório']"
                                        :items="cursos"
                                        item-text="nome"
                                        item-value="id"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <!-- select de direcionado -->
                            <v-row class="mt-n2">
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-select
                                        v-model="aluno.instituicao_id"
                                        :clearable="true"
                                        hide-details="auto"
                                        label="Instituicao"
                                        :rules="[(v) => !!v || 'Instituicao obrigatório']"
                                        :items="instituicaos"
                                        item-text="nome"
                                        item-value="id"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <!-- Botão de marcarConsulta -->
                            <v-row>
                                <v-col class="aluno-modal-marcar text-center">
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
    name: "modal-aluno",
    props: ["value", "alunoId"],
    data() {
        return {
            valid: true,
            titulo: "Novo aluno",

            aluno: {
                id: '',
                nome: '',
                documento: '',
                curso_id: '',
                instituicao_id:''
            },
            cursos: [{ nome: "", id: 0 }],
            instituicaos: [{ nome: "", id: 0 }],
        };
    },
    watch: {
        value: function () {
            this.$axios
                .$get("/curso")
                .then((response) => { this.cursos = response })
                .catch((error) => {
                    this.$emit('abreToast', error);
                });

            this.$axios
                .$get("/instituicao")
                .then((response) => { this.instituicaos = response })
                .catch((error) => {
                    this.$emit('abreToast', error);
                });
        },
        alunoId: function (id) {
            if (id != 0) {
                this.edit(id);
                this.titulo = "Editar aluno"
            } else {
                this.titulo = "Novo aluno"
                this.limpaDados();
            }
        },
    },
    methods: {
        gravar() {
            if (this.$refs.formAluno.validate()) {
                let aluno = JSON.parse(JSON.stringify(this.aluno));

                if (aluno.id == 0) {
                    this.$axios
                        .$post("/aluno", aluno)
                        .then((response) => {
                            this.limpaDados();
                            this.$emit('abreToast', "aluno adicionado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listaAlunos')

                        })
                        .catch((error) => {
                            this.abreToast(error);
                        });
                } else {
                    this.$axios
                        .$put("/aluno/" + aluno.id, aluno)
                        .then((response) => {
                            this.edit(aluno.id);
                            this.$emit('abreToast', "aluno atualizado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listaAlunos')
                        })
                        .catch((error) => {
                            this.abreToast(error);
                        });
                }

            }
        },

        edit(id) {
            this.$axios
                .$get("/aluno/" + id)
                .then((response) => {
                    this.aluno = response;
                })
                .catch((error) => {
                    console.log(error);
                });

        },

        limpaDados() {
            this.aluno = {
                id: '',
                nome: '',
                documento: '',
                curso_id: '',
                instituicao_id:''
            }
            this.$refs.formAluno.reset();
        },

    },
};
</script>

<style>
.aluno-modal-title {
    margin-left: 20px;
}

.aluno-modal-title h4 {
    width: calc(100% - 50px);
    text-align: left;
    border-bottom: 1px solid #b7b7b7;
    line-height: 0.1em;
    margin: 20px 0 20px;
}

.aluno-modal-title h4 span {
    padding: 0 5px;
}

.aluno-modal-marcar {
    border-radius: 10px;
}
</style>
