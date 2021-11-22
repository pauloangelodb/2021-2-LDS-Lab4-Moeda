<template>
    <Head title=" Criar Empresa" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Criar Empresa

                <ButtonVue class="float-right"  @click="voltar"> Voltar </ButtonVue>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        
                        <BreezeValidationErrors class="mb-4" />

                        <form @submit.prevent="submit">
                            <div>
                                <BreezeLabel for="nome" value="Nome" />
                                <BreezeInput id="nome" type="text" class="mt-1 block w-full" v-model="form.nome" required autofocus autocomplete="nome" />
                            </div>

                            <div class="mt-4">
                                <BreezeLabel for="documento" value="Documento" />
                                <BreezeInput id="documento" type="text" class="mt-1 block w-full" v-model="form.documento" required autocomplete="documento" />
                            </div>

                            <div class="text-center mt-4">
                                <ButtonVue class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Gravar
                                </ButtonVue>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import { Head } from '@inertiajs/inertia-vue3';
import ButtonVue from '@/Components/Button.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import BreezeValidationErrors from '@/Components/ValidationErrors.vue'

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        ButtonVue,
        BreezeInput,
        BreezeLabel,
        BreezeValidationErrors
    },

    data() {
        return {
            form: this.$inertia.form({
                nome: '',
                documento: ''
            })
        }
    },


    methods: {
        submit() {
            this.form.post(this.route('empresa.save'), {
               // onFinish: () => this.form.reset('password', 'password_confirmation'),
            })            
        },

        voltar(){
            this.$inertia.get(route('empresa'))
        }
    },
}
</script>
