<template>
    <div class="text-center">
        <v-dialog
            v-model="value"
            scrollable
            max-width="500px"
            transition="dialog-bottom-transition"
            class="vantagem-modal"
            @click:outside="$emit('input', false)"
            @keydown.esc="$emit('input', false)"
        >
            <v-card>
                <v-card-title class="text-h5 vantagem-modal-title">
                    <h4>
                        <span>{{ titulo }}</span>
                    </h4>
                    <v-btn icon @click="$emit('input', false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-form ref="formVantagem" v-model="valid" lazy-validation>
                            <!-- Identificação -->
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="vantagem.nome"
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
                                        v-model="vantagem.valor"
                                        hide-details="auto"
                                        label="Valor"
                                        :rules="[v => !!v || 'Valor é obrigatório']"
                                        type="number"
                                        min="1"
                                        maxlength="6"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <v-col :md="12" :sm="12" :xl="12" cols="12">
                                <v-select
                                    v-model="vantagem.empresa_id"
                                    :clearable="true"
                                    hide-details="auto"
                                    label="Empresa"
                                    :rules="[(v) => !!v || 'Empresa obrigatório']"
                                    :items="empresas"
                                    item-text="pessoa.nome"
                                    item-value="id"
                                    outlined
                                />
                            </v-col>
                                                            <v-row>
                                <v-col class="vantagem-modal-marcar text-center">
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
    name: "modal-vantagem",
    props: ["value", "vantagemId"],
    data() {
        return {
            valid: true,
            titulo: "Nova vantagem",

            vantagem: {
                id: '',
                nome: '',
                valor: '',
                empresa: ''
            },
            empresas:[{id: '', pessoa:{nome:''}}]
        };
    },
    watch: {
        value: function () {
            this.$axios
                .$get("/empresa")
                .then((response) => { this.empresas = response.data })
                .catch((error) => {
                    this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });
                });
        },

        vantagemId: function (id) {
            if (id != 0) {
                this.edit(id);
                this.titulo = "Editar vantagem"
            } else {
                this.titulo = "Novo vantagem"
                this.limpaDados();
            }
        },
    },
    methods: {
        gravar() {
            if (this.$refs.formVantagem.validate()) {
                let vantagem = JSON.parse(JSON.stringify(this.vantagem));

                if (vantagem.id == 0) {
                    this.$axios
                        .$post("/vantagem", vantagem)
                        .then((response) => {
                            this.limpaDados();
                            
                            this.$swal( "vantagem adicionado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listaVantagens')

                        })
                        .catch((error) => {
                            this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });
                            ;
                        });
                } else {
                    this.$axios
                        .$put("/vantagem/" + vantagem.id, vantagem)
                        .then((response) => {
                            this.edit(vantagem.id);
                            this.$swal( "vantagem atualizado com sucesso!");
                            this.$emit('input', false)
                            this.$emit('listavantagems')
                        })
                        .catch((error) => {
                            this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });
                            ;
                        });
                }

            }
        },

        edit(id) {
            this.$axios
                .$get("/vantagem/" + id)
                .then((response) => {
                    this.vantagem = response;
                })
                .catch((error) => {
                    console.log(error);
                });

        },

        limpaDados() {
            this.vantagem = {
                id: '',
                nome: '',
                documento: '',
                curso_id: '',
                instituicao_id: ''
            }
            this.$refs.formVantagem.reset();
        },

    },
};
</script>

<style>
.vantagem-modal-title {
    margin-left: 20px;
}

.vantagem-modal-title h4 {
    width: calc(100% - 50px);
    text-align: left;
    border-bottom: 1px solid #b7b7b7;
    line-height: 0.1em;
    margin: 20px 0 20px;
}

.vantagem-modal-title h4 span {
    padding: 0 5px;
}

.vantagem-modal-marcar {
    border-radius: 10px;
}
</style>
