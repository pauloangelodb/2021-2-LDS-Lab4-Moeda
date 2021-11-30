<template>
  <!--Container-->
  <v-container fluid style="overflow: auto; padding:6vh;">
    <v-card class="mx-auto pa-5 mt-3" width="100%">
      <div class="div-titulo-btn">
        <v-card-title>
          <span class="text-h6">Vantagens</span>
        </v-card-title>
        <v-card-actions>
          <v-btn
            class="mr-2"
            color="primary"
            background="primary"
            @click="abreModal(0)"
          >
            Adicionar Vantagem
          </v-btn>
          <modal-vantagem v-model="modalAtivo" v-bind:vantagemId="vantagemId" @listaVantagens="listaVantagens" />
        </v-card-actions>
      </div>
      <!-- Filtro Simples -->
      <v-card-text class="text-h5">
        <template>
          <v-data-table
            class="elevation-1 tratamento-table"
            v-if="vantagens && vantagens.length > 0"
            :headers="headers"
            :items="vantagens"
            :loading="tabelaCarregando"
            :items-per-page="10"
            :disable-sort="true"
            :footer-props="{
              'disable-items-per-page': true,
              'disable-pagination': true,
              'items-per-page-options': [25]
            }"
          >
          </v-data-table>
          <span class="d-block text-center" v-else>Nenhum Registro Encontrado</span>
          <br>
          <span class="text-muted text-right d-block" id="tratamento-totalItems">
            Total de Items: {{ totalItems }}
          </span>
          <br>
          <v-pagination
            v-model="tabelaPaginaAtual"
            :length="tabelaPaginas"
            @input="listaVantagens"
          />
        </template>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script src="./index.js"></script>

<style lang="scss">
.div-titulo-btn {
  display: flex;
  flex-direction: row;
  align-items: center;
  flex-wrap: wrap;
  justify-content: space-between !important;
}

.tratamento-table{
  .v-data-footer{
    display: none;
  }
}

#tratamento-totalItems {
    font-size: 0.6em;
}

</style>

<script>
import modalVantagem from '@/components/vantagem/modal.vue'
export default {
  layout: "index",
  components: {
    modalVantagem,
  },

  data() {
    return {
      headers: [
        { text: 'Nome', value: 'nome' },
        { text: 'Valor', value: 'valor' },
        { text: 'Empresa', value: 'empresa.pessoa.nome' },      
      ],
      vantagens: [],

      vantagemId: 0,
      modalAtivo: false,

      totalItems: 0,
      tabelaPaginaAtual: 1,
      tabelaPaginas: 1,
      tabelaCarregando: false
    }
  },
  mounted() {
   this.listaVantagens();
  },
  methods: {

    listaVantagens() {
      this.tabelaCarregando = true;

      this.$axios.$get(`/vantagem?pagina=${this.tabelaPaginaAtual}`).then(response => {
        this.vantagens = response.data;      
        this.tabelaPaginas = response.last_page
        this.totalItems = response.total
      }).catch(error => {
        console.log(error)
        this.$swal('Opss..', { text: error.response.data.message, icon: 'error' });

      }).finally(() =>{
        this.tabelaCarregando = false
      })

    },

    abreModal(id){
      if(id){
        this.modalAtivo = !this.modalAtivo;
        this.vantagemId = id;
      }else{
        this.modalAtivo = !this.modalAtivo;
        this.vantagemId = 0;
      }
    },



  }

}

</script>