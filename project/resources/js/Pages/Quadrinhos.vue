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
                    v-model="form.titulo" 
                    label="Título" 
                    hint="Título do Quadrinho" 
                    lazy-rules 
                    :rules="[ val => val && val.length > 0  || 'Informe o título']" 
                    :error="props.errors.titulo" 
                    :error-message="props.errors.titulo" 
                />
        
                <q-input 
                    outlined 
                    v-model="form.autor" 
                    label="Autor" 
                    hint="Nome do Auto" 
                    lazy-rules 
                    :rules="[ val => val && val.length > 0  || 'Informe o nome do autor']" 
                    :error="props.errors.autor" 
                    :error-message="props.errors.autor" 
                />

                <div style="margin-bottom: 5%;">
                    <div class="q-col row items-start">
                        <div class="q-col col-auto" style="margin-right: 5%; width: 20%">
                            <q-input 
                                outlined 
                                v-model="form.edicao" 
                                label="Edição" 
                                hint="Número da Edição"
                                type="text"
                                mask="###"
                                lazy-rules 
                                :rules="[ val => val && val.length > 0  || 'Informe o número da edição']" 
                                :error="props.errors.edicao" 
                                :error-message="props.errors.edicao" 
                            />
                        </div>
                        <div class="q-col col-auto" style="margin-right: 5%; width: 20%">
                            <q-input 
                                outlined 
                                v-model="form.ano" 
                                label="Ano" 
                                hint="Ano de Lançamento" 
                                lazy-rules
                                type="text"
                                mask="####" 
                                :rules="[ val => val && val.length > 0  || 'Informe o ano']" 
                                :error="props.errors.ano" 
                                :error-message="props.errors.ano" 
                            />
                        </div>
                        <div class="q-col col-auto" style="width: 50%">
                            <q-file 
                                clearable 
                                color="blue" 
                                outlined 
                                v-model="form.capa" 
                                label="Capa" 
                                counter 
                                accept="image/*" 
                                hint="Adicione uma imagem de capa" 
                                :error="props.errors.capa" 
                                :error-message="props.errors.capa"
                            >
                                <template v-slot:hint>Adicione uma capa</template>
                            </q-file>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 3%;" align="right">
                <!-- Cadastrar | Atualizar -->
                <q-btn v-if="!isEditing" label="Cadastrar" type="submit" color="red" />
                <q-btn v-else label="Atualizar" @click="onUpdate(form.id)" color="red" />
                <!-- Limpar | Cancelar -->
                <q-btn v-if="!isEditing" label="Limpar" type="reset" color="red" flat class="q-ml-sm" />
                <q-btn v-else label="Cancelar" @click="onCancel" color="red" flat class="q-ml-sm" />
                </div>
            </q-form>
            </div>
        
            <div class="q-pa-md q-gutter-md q-h-full q-mt-md" style="max-width: 85%">
            <q-table title="Quadrinhos" 
                :rows="quadrinhos" 
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
                    <q-th style="width: 15%;" class="text-center">CAPA</q-th>
                    <q-th style="width: 30%;" class="text-center">TÍTULO</q-th>
                    <q-th style="width: 10%;" class="text-center">EDIÇÃO</q-th>
                    <q-th style="width: 10%;" class="text-center">ANO</q-th>
                    <q-th style="width: 20%;" class="text-center">AUTOR</q-th>
                    <q-th style="width: 10%;" class="text-center">OPERAÇÕES</q-th>
                </q-tr>
                </template>
        
                <template v-slot:body="props">
                <q-tr :props="props">
                    <q-td style="width: 15%;" class="text-center">
                    <q-img square>
                        <img :src="'/storage/' + props.row.capa" contain style="width: 48%; height: 90%; object-fit: cover;"/>
                    </q-img>
                    <q-tooltip persistent>
                        <img :src="'/storage/' + props.row.capa" style="max-width: 300px; max-height: 300px; object-fit: cover;" />
                    </q-tooltip>
                    </q-td>
                    <q-td style="width: 30%;" class="text-center">{{ props.row.titulo }}</q-td>
                    <q-td style="width: 10%;" class="text-center">{{ props.row.edicao }}</q-td>
                    <q-td style="width: 10%;" class="text-center">{{ props.row.ano }}</q-td>
                    <q-td style="width: 20%;" class="text-center">{{ props.row.autor }}</q-td>
                    <q-td style="width: 10%;" class="text-center">
                        <q-icon size="25px" name="edit" @click="onEdit(props.row)" color="primary" class="cursor-pointer" />
                        <q-icon size="25px" name="delete" @click="onDelete(props.row.id)" color="red" class="cursor-pointer" />
                        <q-icon size="25px" name="star" @click="onFavorite(props.row.id)" color="yellow" class="cursor-pointer" />
                    </q-td>
                </q-tr>
                </template>
            </q-table>
            </div>
        </q-page-container>  
    </q-layout>

  </template>

<script setup>
    import { router, useForm } from '@inertiajs/vue3'
    import { useQuasar } from 'quasar'
    import { ref } from 'vue'

    const $q = useQuasar()

    const isEditing = ref(false)
    
    const form = useForm({
        titulo: ref(null),
        edicao: ref(null),
        ano: ref(null),
        capa: ref(null),
        autor: ref(null),
    })

    const props = defineProps({
        errors: Object,
        quadrinhos: Object,
        user: Object
    })

    const currentPage = ref(1)
    const rowsPerPage = ref(10)
    const totalItems = ref(0)

    const onPaginationRequest = (pagination) => {
        currentPage.value = pagination.page
        rowsPerPage.value = pagination.rowsPerPage
        loadPage()
    }

    const loadPage = async () => {
        try {
            const response = await axios.get(`/api/quadrinhos?page=${currentPage.value}&per_page=${rowsPerPage.value}`)
            const filteredData = response.data.data.filter(quadrinho => quadrinho.ativo  === 1)
            quadrinhos.value = filteredData
            totalItems.value = filteredData.length
        } catch (error) {
            $q.notify({
                color: 'red-4',
                textColor: 'white',
                icon: 'cloud_done',
                message: 'Erro ao carregar os quadrinhos'
            })
        }
    }

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
        router.post('/quadrinho', form, {
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Quadrinho Cadastrado com Sucesso'
                })
                onReset()
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Cadastrar Quadrinho'
                })
            }
        })
    }

    function onReset() {
        form.reset()
        form.clearErrors()
    }

    function onDelete(id) {
        router.delete('/quadrinho/' + id, {
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Quadrinho Deletado com Sucesso'
                })
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Deletar Quadrinho'
                })
            }
        })
    }

    function onEdit(row) {
        form.id = row.id
        form.titulo = row.titulo
        form.edicao = row.edicao
        form.ano = row.ano
        form.capa = row.capa
        form.autor = row.autor

        const nomeArquivo = row.capa.split('/').pop();
                
        loadFile('/storage/' + row.capa)
        .then((blob) => {
            form.capa = new File([blob], nomeArquivo);
        })
        .catch((error) => {
            console.error(error);
        });

        enterEditMode();
    }

    function onUpdate(id) {
        router.post('/quadrinho/' + id, form, {
            onSuccess: () => {
                $q.notify({
                    color: 'green-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Quadrinho Atualizado com Sucesso'
                })
                onReset()
                exitEditMode()
            },
            onError: () => {
                $q.notify({
                    color: 'red-4',
                    textColor: 'white',
                    icon: 'cloud_done',
                    message: 'Erro ao Atualizar Quadrinho'
                })
            }
        })
    }

    function onCancel() {
        onReset()
        exitEditMode()
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
        isEditing.value = true
    }

    function exitEditMode() {
        isEditing.value = false
    }

    function goToPage(route) {
        const content = router.visit(route)
    }
</script>
