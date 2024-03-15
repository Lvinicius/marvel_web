<template>
    <div class="q-pa-md" style="max-width: 400px">
  
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        class="q-gutter-md"
      >
        <q-input
            filled
            v-model="nome"
            label="Identidade Secreta"
            hint="Nome e Sobrenome"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Informe pelo menos um nome']"
        />

        <q-input
            filled  
            v-model="alcunha"
            label="Alcunha"
            hint="Nome Inventado"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Informe pelo menos uma alcunha']"
        />

        <q-file clearable color="blue" filled v-model="foto" label="Foto" counter accept="image/*">
            <template v-slot:hint>
                Adicione uma Imagem
            </template>
        </q-file>

        <q-select 
            filled 
            v-model="vinculo" 
            :options="options" 
            label="Filiação" 
            hint="Escolha uma Filiação"	
            :rules="[ val => val && val.length > 0 || 'Selecione uma filiação']"/>   
  
        <div>
          <q-btn label="Submit" type="submit" color="primary"/>
          <q-btn label="Reset" type="reset" color="primary" flat class="q-ml-sm" />
        </div>
      </q-form>
  
    </div>
  </template>
  
  <script>
    import { useQuasar } from 'quasar'
    import { ref } from 'vue'

    export default {
        setup () {
            const $q = useQuasar()

            const nome = ref(null)
            const alcunha = ref(null)
            const foto = ref(null)
            const vinculo = ref(null)
            const options = ['Héroi', 'Vilão', 'Anti-Héroi', 'Ajudante', 'Civil', 'Outro']
            
            return {
                nome,
                alcunha,
                foto,
                vinculo,
                options,

                onSubmit () {
                    $q.notify({
                        color: 'green-4',
                        textColor: 'white',
                        icon: 'cloud_done',
                        message: 'Submitted'
                    })
                },

                onReset () {
                    nome.value = null
                    alcunha.value = null
                    foto.value = null
                    vinculo.value = null
                },
            }
        }
    }
</script>