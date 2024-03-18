<template>
  <q-layout view="hHh lpR lfr">
    <q-page-container>
      <q-page class="bg-grey-10 window-height window-width row justify-center items-center">
        <div class="column">
          <div class="row">
            <h5 class="text-h5 text-white q-my-md">Marvel App - CADASTRO</h5>
          </div>
          <div class="row">
            <q-card square bordered class="q-pa-lg shadow-1" style="width: 500px;"> 
              <q-card-section>
                <q-form class="q-gutter-md" @submit="register">
                  <q-input square filled v-model="name" label="Nome" lazy-rules :rules="[val => !!val || 'O nome é obrigatório']"/>
                  <q-input square filled v-model="email" type="Email" label="Email" lazy-rules :rules="[val => !!val || 'O e-mail é obrigatório', val => /.+@.+\..+/.test(val) || 'E-mail inválido']"/>
                  <q-input square filled v-model="password" type="password" label="Senha" lazy-rules :rules="[val => !!val || 'A senha é obrigatória']"/>
                  <q-input square filled v-model="passwordConfirmation" type="password" lazy-rules label="Confirme a Senha" :rules="[val => !!val || 'A confirmação de senha é obrigatória', val => val === password || 'As senhas não coincidem']"/>
                </q-form>
              </q-card-section>
              <q-card-actions class="q-px-md">
                <q-btn unelevated color="red" size="lg" class="full-width" label="Registrar" type="submit" @click="register"/>
              </q-card-actions>
            </q-card>
          </div>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const name = ref('')
const email = ref('')
const password = ref('')
const passwordConfirmation = ref('')

const register = async () => {
    try {
        const response = router.post('/registro', {
            name: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: passwordConfirmation.value
        })
    } catch (error) {
        console.error('Erro ao efetuar registro:', error)
    }
}
</script>
