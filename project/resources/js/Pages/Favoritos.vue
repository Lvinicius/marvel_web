<template>
    <q-header reveal elevated class="bg-primary text-white bg-grey-10" height-hint="98" align="center">
        <q-toolbar>
            <q-toolbar-title>
            <q-img src="/storage/Marvel_Logo.svg.png" alt="Marvel Logo" width="180px" height="70px"/>          
        </q-toolbar-title>
        </q-toolbar>

        <q-tabs align="center">
            <q-tab @click="goToPage('/personagem')" label="Personagens" />
            <q-tab @click="goToPage('/quadrinho')" label="Quadrinhos" />
            <q-tab @click="goToPage('/favoritos')" label="Favoritos" />
        </q-tabs>
    </q-header> 
  </template>
  
<script setup>
    import { router } from '@inertiajs/vue3'

    function goToPage(route) {
        const content = router.visit(route)
    }
</script>
  