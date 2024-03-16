<template>
    <div class="q-pa-md" style="max-width: 50%">
  
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
            outlined
            v-model="form.nome"
            label="Identidade Secreta"
            hint="Nome e Sobrenome"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Informe pelo menos um nome']"
            :error="props.errors.nome"
            :error-message="props.errors.nome"
        />

        <q-input
            outlined  
            v-model="form.alcunha"
            label="Alcunha"
            hint="Nome Inventado"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Informe pelo menos uma alcunha']"
            :error="props.errors.alcunha"
            :error-message="props.errors.alcunha"
        />

        <q-file 
            clearable 
            color="blue" 
            outlined 
            v-model="form.foto" 
            label="Foto" 
            counter            
            accept="image/*"
            :error="props.errors.foto"
            :error-message="props.errors.foto"
            >
            <template v-slot:hint>
                Adicione uma Imagem
            </template>
        </q-file>

        <q-select 
            outlined 
            v-model="form.vinculo" 
            :options="options" 
            label="Afiliação" 
            hint="Escolha uma Afiliação"	
            :rules="[ val => val && val.length > 0 || 'Selecione uma afiliação']"
            :error="props.errors.vinculo"
            :error-message="props.errors.vinculo"
            />

        <div>
          <q-btn label="Cadastrar" type="submit" color="primary"/>
          <q-btn label="Limpar" type="reset" color="primary" flat class="q-ml-sm" />
        </div>
        
      </q-form>      
    </div>

    <div class="q-pa-md">
        <q-table
            title="Personagens"
            :rows="personagens"
            row-key="personagens.id"
            separator="cell"
        >
            <template v-slot:header>
                <q-tr>
                    <q-th style="width: 20%;" class="text-center">FOTO</q-th>
                    <q-th style="width: 20%;" class="text-center">NOME</q-th>
                    <q-th style="width: 20%;" class="text-center">ALCUNHA</q-th>
                    <q-th style="width: 30%;" class="text-center">AFILIAÇÃO</q-th>
                    <q-th style="width: 10%;" class="text-center">OPERAÇÕES</q-th>
                </q-tr>
            </template>

            <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td style="width: 20%;" class="text-center">
                        <q-avatar>
                        <img :src="'data:image/png;base64,' + props.row.foto">
                        </q-avatar>
                    </q-td>
                    <q-td style="width: 20%;" class="text-center">{{ props.row.nome }}</q-td>
                    <q-td style="width: 20%;" class="text-center">{{ props.row.alcunha }}</q-td>
                    <q-td style="width: 30%;" class="text-center">{{ props.row.vinculo }}</q-td>
                    <q-td style="width: 10%;" class="text-center">
                        <q-icon size="25px" name="edit" @click="editar(props.row.id)" color="primary" class="cursor-pointer"/>
                        <q-icon size="25px" name="delete" @click="deletar(props.row.id)" color="red" class="cursor-pointer"/> 
                    </q-td>
                </q-tr>
            </template>
        </q-table>
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
        errors: Object,
        personagens: Object
    })
    
    function onSubmit() {
        router.post('/personagem', form,{
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Cadastrado com Sucesso'
                });
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