<template>
  <!--Container-->
  <v-container fluid style="overflow: auto; padding:6vh;">
    <v-card class="mx-auto pa-5 mt-3" width="100%">
      <div class="div-titulo-btn">
        <v-card-title>
          <span class="text-h6">Alunos</span>
        </v-card-title>
        <v-card-actions>
          <v-btn
            class="mr-2"
            color="primary"
            background="primary"
            @click="abreModal(0)"
          >
            Adicionar Aluno
          </v-btn>
          <modal-aluno v-model="modalAtivo" v-bind:tratamentoId="tratamentoId" @listaAlunos="listaAlunos" @abreToast="abreToast" /> 
        </v-card-actions>
      </div>
      <!-- Filtro Simples -->
      <v-card-text class="text-h5">
        <template>
          <v-data-table
            class="elevation-1 tratamento-table"
            v-if="alunos && alunos.length > 0"
            :headers="headers"
            :items="alunos"
            :loading="tabelaCarregando"
            :items-per-page="10"
            :disable-sort="true"
            :footer-props="{
              'disable-items-per-page': true,
              'disable-pagination': true,
              'items-per-page-options': [25]
            }"
          >
            <!-- <template v-slot:item.direcionado= "{ item }">
              {{item.direcionado == "HEPB" ? "Hepatite B":  "Hepatite C"}}
            </template> -->
            <!-- <template v-slot:item.actions="{ item }">
            
              <v-icon color="primary" class="mr-2" @click="abreModal(item.id)">
                mdi-square-edit-outline
              </v-icon>

            </template> -->
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
            @input="listaAlunos"
          />
        </template>
      </v-card-text>
    </v-card>

    <v-snackbar v-model="toast" shaped>
      {{ toastMensagem }}

      <template v-slot:action="{ attrs }">
        <v-btn color="blue" text v-bind="attrs" @click="toast = false">
          Ok
        </v-btn>
      </template>
    </v-snackbar>
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
import modalAluno from '@/components/aluno/modal.vue'
export default {
  layout: "index",
  components: {
    modalAluno,
  },

  data() {
    return {
      headers: [
        { text: 'Nome', value: 'pessoa.nome' },
        { text: 'Documeneto', value: 'pessoa.documento' },
        { text: 'Curso', value: 'curso.nome' },
        { text: 'Instituicao', value: 'instituicao.nome' },      
        { text: 'Saldo', value: 'conta.saldo' },        
      ],
      alunos: [],

      tratamentoId: 0,
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
   this.listaAlunos();
  },
  methods: {

    listaAlunos() {
      this.tabelaCarregando = true;

      this.$axios.$get(`/aluno?pagina=${this.tabelaPaginaAtual}`).then(response => {
        this.alunos = response.data;      
        this.tabelaPaginas = response.last_page
        this.totalItems = response.total
      }).catch(error => {
        console.log(error)
        //this.$Message.alert(error.response.data.message,'Erro', {type: 'error', msgBody: {style: {width: '30%'}}})
      }).finally(() =>{
        this.tabelaCarregando = false
      })

    },

    abreModal(id){
      if(id){
        this.modalAtivo = !this.modalAtivo;
        this.tratamentoId = id;
      }else{
        this.modalAtivo = !this.modalAtivo;
        this.tratamentoId = 0;
      }
    },

    abreToast(mensagem) {
      this.toastMensagem = mensagem;
      this.toast = true;
    },

  }

}

</script>