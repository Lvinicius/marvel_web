<template>
    <q-layout view="hHh lpR lfr"> 
      <q-header reveal elevated class="bg-primary text-white bg-grey-10" height-hint="98" align="center">
        <q-toolbar>
          <q-toolbar-title class="q-mr-auto" style="position: relative;">
            <q-img src="/storage/Marvel_Logo.svg.png" alt="Marvel Logo" width="180px" height="70px"/>          
          </q-toolbar-title>
          <div style="display: flex; align-items: right; position: absolute; top: 10%; right: 1%; display: flex; align-items: center;">
            <div>
              <span>{{ user.name }}</span>
            </div>
            <div style="margin-left: 6px;">
              <q-btn-dropdown dense size="sm" color="red" rounded>            
                <q-list>
                  <q-item clickable @click="logout" v-close-popup>
                    <q-item-section>
                      <q-item-label>Logout</q-item-label>
                    </q-item-section>
                  </q-item>
                </q-list>
              </q-btn-dropdown>
            </div>
          </div>
        </q-toolbar>
  
        <q-tabs align="center">
            <q-tab @click="goToPage('/personagem')" label="Personagens" />
            <q-tab @click="goToPage('/quadrinho')" label="Quadrinhos" />
            <q-tab @click="goToPage('/favoritos')" label="Favoritos" />
      </q-tabs>
      </q-header> 
  
      <q-page-container align="center">
      </q-page-container>
    </q-layout>
</template>
  
<script setup>
    import { router } from '@inertiajs/vue3'

    const props=defineProps({
        errors: Object,
        personagens: Object,
        quadrinhos: Object,
        user: Object
    })

    function goToPage(route) {
        const content = router.visit(route)
    }

    const logout = async () => {
    try {
      const response = router.post('/logout')
      if (response.data.success) {
        // Redirecionar para a página de login ou qualquer outra página apropriada após o logout
        router.replace('/login')
      } else {
        console.error('Erro ao efetuar logout:', response.data.message)
      }
    } catch (error) {
      console.error('Erro ao efetuar logout:', error)
      // Lógica para lidar com erros de logout
    }
  } 
</script>
  