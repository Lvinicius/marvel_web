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
    <div v-if="personagens.length > 0">
            <h3>Personagens Favoritos</h3>            
            <q-img 
            v-for="personagem in personagens" 
            :key="personagem" 
            :src="'/storage/' + personagem.foto" 
            alt="Foto do Personagem" 
            class="personagem-img" 
            style="max-width: 240px; height: 270px; margin: 1%;"
            :fit="personagem"
            >
                <div class="absolute-bottom text-subtitle1 text-center">
                    {{ personagem.nome }}
                    <q-icon
                    size="45px"
                    name="star"
                    @click="onFavorite(personagem.id)"
                    color="yellow"
                    class="cursor-pointer absolute-right"
                    style="margin: 5px; cursor: pointer !important;"
                    >
                        <q-tooltip class="bg-grey" anchor="bottom middle" self="bottom middle" :offset="[50, 50]">Desmarcar</q-tooltip>
                    </q-icon>
                </div>                
            </q-img>            
    </div>

    <div v-if="quadrinhos.length > 0">
            <h3>Quadrinhos Favoritos</h3>            
            <q-img 
            v-for="quadrinho in quadrinhos" 
            :key="quadrinho" 
            :src="'/storage/' + quadrinho.capa" 
            alt="Foto do Quadrinho" 
            class="quadrinho-img" 
            style="max-width: 240px; height: 370px; margin: 1%;"
            :fit="quadrinho"
            >
                <div class="absolute-bottom text-subtitle1 text-center">
                    {{ quadrinho.titulo }}
                    <q-icon
                    size="45px"
                    name="star"
                    @click="onFavoritequadrinho(quadrinho.id)"
                    color="yellow"
                    class="cursor-pointer absolute-right"
                    style="margin: 5px; cursor: pointer !important;"
                    >
                        <q-tooltip class="bg-grey" anchor="top middle" self="bottom middle" :offset="[20, 20]">Desmarcar</q-tooltip>
                    </q-icon>
                </div>                
            </q-img>            
    </div>
    </q-page-container>       
  </q-layout>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import {ref, computed} from 'vue'

const props = defineProps({
  errors: Object,
  personagens: Object,
  quadrinhos: Object,
  user: Object
})

function goToPage(route) {
  router.visit(route)
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

function onFavorite(id){
        router.post('/personagemfavorito/'+ id, {
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Desmarcado com Sucesso'
                });
                onReset();
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Desmarcar Personagem'
                })
            }
        })
    }

    function onFavoritequadrinho(id){
        router.post('/quadrinhofavorito/'+ id, {
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Quadrinho Desmarcado com Sucesso'
                });
                onReset();
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Desmarcar Quadrinho'
                })
            }
        })
    }

</script>


  