<template>
  <v-container fluid style="overflow: auto; padding:6vh;">
    <v-card class="mx-auto pa-5 mt-3" width="100%">
      <div class="div-titulo-btn">
        <v-card-title>
          <!-- <span class="text-5"> Bem vindo {{ $store.getters['login/me'].name }} </span> -->
          <span class="text-h6">Transações</span>
        </v-card-title>
        <v-card-actions>
          <v-btn
            class="mr-2"
            color="primary"
            background="primary"
            @click="modalAtivo = !modalAtivo"
          >Transacionar</v-btn>
          <modal-transacao v-model="modalAtivo" @listaTransacoes="listaTransacoes" />
        </v-card-actions>
      </div>
      <!-- Filtro Simples -->
      <v-card-text class="text-h5">
        <template>
          <v-data-table
            class="elevation-1 tratamento-table"
            v-if="transacoes && transacoes.length > 0"
            :headers="headers"
            :items="transacoes"
            :loading="tabelaCarregando"
            :items-per-page="10"
            :disable-sort="true"
            :footer-props="{
              'disable-items-per-page': true,
              'disable-pagination': true,
              'items-per-page-options': [25]
            }"
          ></v-data-table>
          <span class="d-block text-center" v-else>Nenhum Registro Encontrado</span>
          <br />
          <span
            class="text-muted text-right d-block"
            id="tratamento-totalItems"
          >Total de Items: {{ totalItems }}</span>
          <br />
          <v-pagination
            v-model="tabelaPaginaAtual"
            :length="tabelaPaginas"
            @input="listaTransacoes"
          />
        </template>
      </v-card-text>
    </v-card>

    <v-snackbar v-model="toast" shaped>
      {{ toastMensagem }}
      <template v-slot:action="{ attrs }">
        <v-btn color="blue" text v-bind="attrs" @click="toast = false">Ok</v-btn>
      </template>
    </v-snackbar>
  </v-container>
</template>
<script>
import modalTransacaoVue from "../components/modalTransacao.vue";
export default {
  layout: "index",
  components: {
    modalTransacaoVue,
  },

  data() {
    return {
      headers: [
        { text: 'De', value: 'conta_origem.pessoas[0].nome' },
        { text: 'Para', value: 'conta_destino.pessoas[0].nome' },
        { text: 'Valor', value: 'valor' },
        { text: 'Data', value: 'data' },

      ],
      transacoes: [],

      toast: false,
      toastMensagem: '',
      modalAtivo: false,

      totalItems: 0,
      tabelaPaginaAtual: 1,
      tabelaPaginas: 1,
      tabelaCarregando: false
    }
  },
  mounted() {
    this.listaTransacoes();
  },
  methods: {

    listaTransacoes() {
      this.tabelaCarregando = true;

      this.$axios.$get(`/movimentacao?pagina=${this.tabelaPaginaAtual}`).then(response => {
        this.transacoes = response.data;
        this.tabelaPaginas = response.last_page
        this.totalItems = response.total
      }).catch(error => {
        console.log(error)
        this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });

      }).finally(() => {
        this.tabelaCarregando = false
      })

    },

    abreToast(mensagem) {
      this.toastMensagem = mensagem;
      this.toast = true;
    },

  }

}
</script>