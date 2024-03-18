<template>
    <q-page class="q-pa-md">
      <q-card>
        <q-card-section>
          <q-card-title class="text-h6">{{ $t('Login') }}</q-card-title>
          <q-form @submit="login">
            <q-input
              v-model="email"
              label="{{ $t('Email Address') }}"
              type="email"
              :error="$v.email.$error"
              @input="$v.email.$touch()"
            />
            <q-input
              v-model="password"
              label="{{ $t('Password') }}"
              type="password"
              :error="$v.password.$error"
              @input="$v.password.$touch()"
            />
            <q-checkbox
              v-model="remember"
              label="{{ $t('Remember Me') }}"
            />
            <div class="row q-mt-md">
              <div class="col">
                <q-btn
                  color="primary"
                  label="{{ $t('Login') }}"
                  type="submit"
                  :loading="loading"
                />
              </div>
              <div class="col">
                <q-btn
                  color="primary"
                  label="{{ $t('Forgot Your Password?') }}"
                  @click="forgotPassword"
                />
              </div>
            </div>
          </q-form>
        </q-card-section>
      </q-card>
    </q-page>
  </template>
  
  <script setup>
  import { ref } from 'vue'
  const store = useStore()
  const { t } = useI18n()
  
  const email = ref('')
  const password = ref('')
  const remember = ref(false)
  const loading = ref(false)
  
  const login = async () => {
    try {
      loading.value = true
      await store.dispatch('auth/login', { email: email.value, password: password.value, remember: remember.value })
    } catch (error) {
      console.error('Error while logging in:', error)
    } finally {
      loading.value = false
    }
  }
  
  const forgotPassword = () => {
    // Handle forgot password logic here
  }
  </script>
  