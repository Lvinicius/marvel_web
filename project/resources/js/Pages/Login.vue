<template>
  <q-layout view="hHh lpR lfr">
    <q-page-container>
      <q-page class="bg-grey-10 window-height window-width row justify-center items-center">
      <div class="column">
        <div class="row">
          <h5 class="text-h5 text-white q-my-md">Marvel App</h5>
        </div>
        <div class="row">
          <q-card square bordered class="q-pa-lg shadow-1" style="width: 380px;">
            <q-card-section>
              <q-form class="q-gutter-md">
                <q-input square filled v-model="email" type="email" label="Email" lazy-rules :rules="[val => !!val || 'O e-mail é obrigatório', val => /.+@.+\..+/.test(val) || 'E-mail inválido']"/>
                <q-input square filled v-model="password" type="password" lazy-rules label="Senha" :rules="[val => !!val || 'A senha é obrigatória']"/>
              </q-form>
            </q-card-section>
            <q-card-actions class="q-px-md">
              <q-btn unelevated color="red" size="lg" class="full-width" label="Login" @click="login"/>
            </q-card-actions>
            <q-card-section class="text-center q-pa-none">
              <p class="text-grey-6">Não é Cadastrado? <a @click="goToPage('/registro')" href="#" style="cursor: pointer;" class="text-red-10">Junte-se aos Vingadores</a></p>
            </q-card-section>
          </q-card>
        </div>
      </div>
  </q-page>
    </q-page-container>
    <q-dialog v-model="alert">
      <q-card>
        <q-card-section>
          <div class="text-h6">Erro ao Logar</div>
          <p>Email ou senha incorretos! Por favor, tente novamente.</p>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn color="red" label="OK" @click="alert = false" />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-layout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const alert = ref(false)
const email = ref('')
const password = ref('')

const login = async () => {
  try {
    const response = router.post('/login', { email: email.value, password: password.value })
    if (response === undefined) {      
      // alert.value = true
    } else {
      router.replace('/personagem')
    }
  } catch (error) {
    alert.value = true
    console.error('Erro ao efetuar login:', error)
  }
}

function goToPage(route) {
  const content = router.visit(route)
}
</script>