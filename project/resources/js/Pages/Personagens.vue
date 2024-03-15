<template>
    <div class="q-pa-md" style="max-width: 400px">
  
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
            filled
            v-model="form.nome"
            label="Identidade Secreta"
            hint="Nome e Sobrenome"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Informe pelo menos um nome']"
        />

        <q-input
            filled  
            v-model="form.alcunha"
            label="Alcunha"
            hint="Nome Inventado"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Informe pelo menos uma alcunha']"
        />

        <q-file clearable color="blue" filled v-model="form.foto" label="Foto" counter accept="image/*">
            <template v-slot:hint>
                Adicione uma Imagem
            </template>
        </q-file>

        <q-select 
            filled 
            v-model="form.vinculo" 
            :options="options" 
            label="Filiação" 
            hint="Escolha uma Filiação"	
            :rules="[ val => val && val.length > 0 || 'Selecione uma filiação']"/>   
  
        <div>
          <q-btn label="Cadastrar" type="submit" color="primary"/>
          <q-btn label="Limpar" type="reset" color="primary" flat class="q-ml-sm" />
        </div>
      </q-form>
  
    </div>
  </template>
  
  <script setup>
    import {router, useForm} from '@inertiajs/vue3'
    import {useQuasar} from 'quasar'
    import {ref} from 'vue'

    const $q = useQuasar()
    
    const options = ['Héroi', 'Vilão', 'Anti-Héroi', 'Ajudante', 'Civil', 'Outro']
     
    const form = useForm({
        nome: ref(null),
        alcunha: ref(null),
        foto: ref(null),
        vinculo: ref(null),
    })

    const props=defineProps({
        errors: Object
    })
    
    function onSubmit() {
        router.post('/personagem', form,{
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Cadastrado com Sucesso'
                })
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Cadastrar Personagem'
                })
            }
        })
    }

    function onReset() {
        form.reset()
    }

</script>