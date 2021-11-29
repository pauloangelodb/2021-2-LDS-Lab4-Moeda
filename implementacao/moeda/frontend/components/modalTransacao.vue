<template>
    <div class="text-center">
        <v-dialog
            v-model="value"
            scrollable
            max-width="500px"
            transition="dialog-bottom-transition"
            class="transacao-modal"
            @click:outside="$emit('input', false)"
            @keydown.esc="$emit('input', false)"
        >
            <v-card>
                <v-card-title class="text-h5 transacao-modal-title">
                    <h4>
                        <span>{{ titulo }}</span>
                    </h4>
                    <v-btn icon @click="$emit('input', false)">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-form ref="formTransacao" v-model="valid" lazy-validation>
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-select
                                        v-model="transacao.conta_origem_id"
                                        :clearable="true"
                                        hide-details="auto"
                                        label="Professor"
                                        :rules="[(v) => !!v || 'Professor obrigatório']"
                                        :items="professores"
                                        item-text="pessoa.nome"
                                        item-value="pessoa.conta.id"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <!-- select de direcionado -->
                            <v-row class="mt-n2">
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-select
                                        v-model="transacao.conta_destino_id"
                                        :clearable="true"
                                        hide-details="auto"
                                        label="Aluno"
                                        :rules="[(v) => !!v || 'Aluno obrigatório']"
                                        :items="alunos"
                                        item-text="pessoa.nome"
                                        item-value="pessoa.conta.id"
                                        outlined
                                    />
                                </v-col>
                            </v-row>
                            <v-row>
                                <v-col :md="12" :sm="12" :xl="12" cols="12">
                                    <v-text-field
                                        v-model="transacao.valor"
                                        hide-details="auto"
                                        label="Valor"
                                        :rules="[v => !!v || 'Valor é obrigatório']"
                                        maxlength="30"
                                        type="number"
                                        outlined
                                    />
                                </v-col>
                            </v-row>

                            <v-row>
                                <v-col class="transacao-modal-marcar text-center">
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
    name: "modal-transacao",
    props: ["value", "transacaoId"],
    data() {
        return {
            valid: true,
            titulo: "Novo transacao",

            transacao:{
                conta_origem_id: '',
                conta_destino_id: '',
                valor: ''
            },

            alunos: [{ pessoa:{nome: ''}, conta:{id:'', saldo:''} }],
            professores: [{ pessoa:{nome: ''}, conta:{id:'', saldo:''} }],

        };
    },
    watch: {
        value: function () {
            this.$axios
                .$get("/professor")
                .then((response) => { this.professores = response.data })
                .catch((error) => {
                    this.$emit('abreToast', error);
                });

            this.$axios
                .$get("/aluno")
                .then((response) => { this.alunos = response.data })
                .catch((error) => {
                    this.$emit('abreToast', error);
                });
        },
    },
    methods: {
        gravar() {
            if (this.$refs.formTransacao.validate()) {
                let transacao = JSON.parse(JSON.stringify(this.transacao));

                this.$axios
                    .$post("/movimentacao", transacao)
                    .then((response) => {
                        this.limpaDados();
                        this.$emit('abreToast', "transacao adicionado com sucesso!");
                        this.$emit('input', false)
                        this.$emit('listaTransacoes')
                    })
                    .catch((error) => {
                        this.abreToast(error);
                    });


            }
        },

        limpaDados() {
            this.transacao={
                conta_origem_id: '',
                conta_destino_id: '',
                valor: ''
            },
            this.$refs.formTransacao.reset();
        },

    },
};
</script>

<style>
.transacao-modal-title {
    margin-left: 20px;
}

.transacao-modal-title h4 {
    width: calc(100% - 50px);
    text-align: left;
    border-bottom: 1px solid #b7b7b7;
    line-height: 0.1em;
    margin: 20px 0 20px;
}

.transacao-modal-title h4 span {
    padding: 0 5px;
}

.transacao-modal-marcar {
    border-radius: 10px;
}
</style>
