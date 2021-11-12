<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Aluno
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                                                        <Label v-bind:value="'Label teste'"/>
                                    <Input v-model="inputTeste" />
                        <table>
                        <br/>
                            <thead>
                                <tr>
                                   <td> Nome</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                   <td> teste </td>
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
import Label from '../Components/Label.vue'
import Input from '../Components/Label.vue'

import { Head } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Label,
        Input
    },

    data() {
        return {
            inputTeste: '',
        }
    },

    watch: {
        inputTeste: (val) => { console.log(val) }
    }
}
</script>
