<template>
    <q-layout view="hHh lpR lfr">  
    <q-header reveal elevated class="bg-primary text-white bg-grey-10" height-hint="98" align="center">
      <q-toolbar>
        <q-toolbar-title class="q-mr-auto" style="position: relative;">
            <q-img src="/storage/Marvel_Logo.svg.png" alt="Marvel Logo" width="180px" height="70px"/>          
        </q-toolbar-title>
        <div style="display: flex; align-items: right; position: absolute; top: 10%; right: 1%; display: flex; align-items: center;">
            <div>
                <span >{{ user.name }}</span>
            </div>
            <div style="margin-left: 6px;">
                <q-btn-dropdown
                    dense
                    size="sm"
                    color="red"
                    rounded
                >            
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
        <div class="q-pa-md" style="max-width: 65%">  
      <q-form
        @submit="onSubmit"
        @reset="onReset"
        @edit="onEdit"
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
            ref="nome"
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

        <div style="margin-bottom: 5%;">
            <div class="q-col row items-start">
                <div class="q-col col-auto" style="margin-right: 5%; width: 35%">
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
                </div>
                <div class="q-col col-auto" style="width: 60%">
                    <q-select 
                        outlined 
                        v-model="form.vinculo" 
                        :options="options" 
                        label="Afiliação" 
                        hint="Escolha uma Afiliação"
                        lazy-rules	
                        :rules="[ val => !!val || 'Selecione uma afiliação']"
                        :error="props.errors.vinculo"
                        :error-message="props.errors.vinculo"
                    />  
                </div>   
            </div> 
        </div>

        <div style="margin-top: 3%;" align="right">
            <!-- Cadastrar | Atualizar -->
            <q-btn v-if="!isEditing" label="Cadastrar" type="submit" color="red"/>
            <q-btn v-else label="Atualizar" @click="onUpdate(form.id)" color="red"/>
            <!-- Limpar | Cancelar -->
            <q-btn v-if="!isEditing" label="Limpar" type="reset" color="red" flat class="q-ml-sm"/>
            <q-btn v-else label="Cancelar" @click="onCancel" color="red" flat class="q-ml-sm"/>
        </div>
          
      </q-form>      
    </div>

    <div class="q-pa-md q-gutter-md q-h-full q-mt-md" style="max-width: 85%">
        <q-table
            title="Personagens"
            :rows="personagens"
            :rows-per-page-options="[3, 5, 10, 20, 30]" 
            :rows-per-page="rowsPerPage"
            :page="currentPage"
            :rows-in-page="totalItems"
            @request="onPaginationRequest"
            row-key="id"
            separator="cell"
            rows-per-page-label="Itens por Página"
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
                                <img :src="'/storage/' + props.row.foto">
                            </q-avatar>
                        </q-td>
                        <q-td style="width: 20%;" class="text-center">{{ props.row.nome }}</q-td>
                        <q-td style="width: 20%;" class="text-center">{{ props.row.alcunha }}</q-td>
                        <q-td style="width: 30%;" class="text-center">{{ props.row.vinculo }}</q-td>
                        <q-td style="width: 10%;" class="text-center">
                            <q-icon size="25px" name="edit" @click="onEdit(props.row)" color="primary" class="cursor-pointer">
                                <q-tooltip   q-tooltip class="bg-primary" anchor="top middle" self="bottom middle" :offset="[10, 10]">Editar</q-tooltip>
                            </q-icon>
                            <q-icon size="25px" name="delete" @click="onDelete(props.row.id)" color="red" class="cursor-pointer">
                                <q-tooltip class="bg-red" anchor="top middle" self="bottom middle" :offset="[10, 10]">Excluir</q-tooltip>
                            </q-icon>
                            <q-icon
                                size="25px"
                                name="star"
                                :color="props.row.favorito ? 'yellow' : 'grey-4'"
                                class="cursor-pointer"
                                @click="props.row.favorito ? onUnfavorite(props.row.favorito_id) : onFavorite(props.row, user)"
                            >
                                <q-tooltip
                                    class="bg-yellow-8"
                                    anchor="top middle"
                                    self="bottom middle"
                                    :offset="[10, 10]"
                                >
                                    {{ props.row.favorito ? 'Remover dos Favoritos' : 'Adicionar aos Favoritos' }}
                                </q-tooltip>
                            </q-icon>
                        </q-td>
                    </q-tr>
            </template>
        </q-table>
    </div>
    </q-page-container>  
  </q-layout>    
</template>
  
  <script setup>
    import {router, useForm} from '@inertiajs/vue3'
    import {useQuasar} from 'quasar'
    import {ref} from 'vue'

    const $q = useQuasar()

    const isEditing = ref(false)
    
    const options = ['Héroi', 'Vilão', 'Anti-Héroi', 'Ajudante', 'Civil', 'Outro']
     
    const form = useForm({
        nome: ref(null),
        alcunha: ref(null),
        foto: ref(null),
        vinculo: ref(null),
    }) 

    const props=defineProps({
        errors: Object,
        personagens: Object,
        user: Object
    })  
    
    const currentPage = ref(1); 
    const rowsPerPage = ref(10);
    const totalItems = ref(0); 

    const onPaginationRequest = (pagination) => {
        currentPage.value = pagination.page;
        rowsPerPage.value = pagination.rowsPerPage;
        loadPage();
    };

    const loadPage = async () => {
        try {
            const response = await axios.get(`/api/personagens?page=${currentPage.value}&per_page=${rowsPerPage.value}`);
            const filteredData = response.data.data.filter(personagem => personagem.ativo === 1);
            personagens.value = filteredData;
            totalItems.value = filteredData.length;
        } catch (error) {
            $q.notify({
                color: 'red-4',
                textColor: 'white',
                icon: 'cloud_done',
                message: 'Erro ao carregar os personagens'
            });
        }
    };
    const logout = async () => {
        try {
            const response = await router.post('/logout')
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
    
    function onSubmit() {
        router.post('/personagem', form,{
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Cadastrado com Sucesso'
                }); 
                onReset();        
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
        form.clearErrors()
    }

    function onDelete(id){
        router.delete('/personagem/'+ id, {
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Deletado com Sucesso'
                });
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Deletar Personagem'
                })
            }
        })
    }

    function onEdit(row){        
        form.id = row.id;
        form.nome = row.nome;
        form.alcunha = row.alcunha;
        form.vinculo = row.vinculo;         
        
        const nomeArquivo = row.foto.split('/').pop();
                
        loadFile('/storage/' + row.foto)
        .then((blob) => {
            form.foto = new File([blob], nomeArquivo);
        })
        .catch((error) => {
            console.error(error);
        });

        enterEditMode();
    }

    function onUpdate(id){
        router.post('/personagem/'+ id, form, {
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Atualizado com Sucesso'
                });
                onReset();
                exitEditMode();
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Atualizar Personagem'
                })
            }
        })
    }

    function onCancel(){
        onReset()
        exitEditMode()
    }

    function onUnfavorite(id){
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

    function onFavorite(row, user){
        const data = {
            user_id: user.id,
            personagem_id: row.id,
            alcunha: row.alcunha,
            foto: row.foto
        };

        router.post('/personagemfavorito', data,{
            preserveScroll: true,
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Personagem Marcado com Sucesso'
                }); 
                onReset();        
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Marcar Personagem'
                })
            }
        })
    }

    function loadFile(url) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', url, true);
            xhr.responseType = 'blob';

            xhr.onload = () => {
                if (xhr.status === 200) {
                    resolve(xhr.response);
                } else {
                    reject(new Error('Falha ao carregar o arquivo'));
                }
            };

            xhr.onerror = () => {
                reject(new Error('Erro de rede ao carregar o arquivo'));
            };

            xhr.send();
        });
    }

    function enterEditMode() {
        isEditing.value = true;
    }

    function exitEditMode() {
        isEditing.value = false;
    }
    
    function goToPage(route) {
       const content = router.visit(route)
    }

</script>