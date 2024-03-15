<template>
    <q-layout view="hHh lpR lfr">
  
      <q-header reveal elevated class="bg-primary text-white bg-grey-10" height-hint="98" align="left">
        <q-toolbar>
          <!-- <q-btn dense flat round icon="menu" @click="toggleLeftDrawer" /> -->
  
          <q-toolbar-title>
            <q-avatar>
              <img src="https://cdn.quasar.dev/logo-v2/svg/logo-mono-white.svg">
            </q-avatar>
            MARVEL
          </q-toolbar-title>
        </q-toolbar>
  
        <q-tabs align="left">
          <q-route-tab to="/personagens" label="Personagens" />
          <q-route-tab to="/page2" label="Quadrinhos" />
          <q-route-tab to="/page3" label="Usuario" />
        </q-tabs>
      </q-header>
  
      <!-- <q-drawer show-if-above v-model="leftDrawerOpen" side="left" behavior="desktop" elevated>
        
      </q-drawer> -->
  
      <q-page-container>
        <router-view />
      </q-page-container>
  
    </q-layout>
  </template>
  
  <script>
  import { ref } from 'vue'
  
  export default {
    
    setup () {
      const leftDrawerOpen = ref(false)
  
      return {
        leftDrawerOpen,
        toggleLeftDrawer () {
          leftDrawerOpen.value = !leftDrawerOpen.value
        }
      }
    }
  }
  </script>