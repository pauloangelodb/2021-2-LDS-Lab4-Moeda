<template>
    <Head title="Aluno" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Aluno

                <ButtonVue class="float-right"  @click="create"> Criar Aluno </ButtonVue>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <table>
                            <thead>
                                <tr>
                                   <th> Nome </th>
                                   <th> Documento </th>
                                   <th> Saldo </th>
                                   <th> Instituicao </th>
                                </tr>
                            </thead>
                            <tbody v-for="(item, index) in $page.props.data" :key="index">
                                <tr>
                                   <td> {{item.pessoa.nome}} </td>
                                   <td> {{item.pessoa.documento}} </td>
                                   <td> {{item.pessoa.conta.saldo}} </td>
                                   <td> {{item.instituicao.nome}} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import Label from '@/Components/Label.vue'
import Input from '@/Components/Input.vue'
import ButtonVue from '@/Components/Button.vue';

import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Label,
        Input,
        ButtonVue
    },

    data() {
        return {
            inputTeste: '',
        }
    },

    watch: {
        inputTeste: (val) => { console.log(val) }
    },

    methods: {
        create(){
            this.$inertia.get(route('aluno.create'))
        }
    },  
}
</script>
