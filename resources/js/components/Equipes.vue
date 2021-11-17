<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- -->
                <!-- Botão Adicionar ------------------------------------------------------------------------------- -->
                <div class="d-md-flex justify-content-md-end mb-2">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalEquipe">
                        <i class="fas fa-user-plus"></i>
                    </button>
                </div>
                <!--fim botão adicionar ---------------------------------------------------------------------------- -->
                <card-component titulo="Equipes">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="equipes.data"
                            :visualizar="{visivel: true, dataToggle: 'modal',dataTarget: '#modalEquipeVisualizar'}"
                            :atualizar="true"
                            :remover="{visivel: true, dataToggle: 'modal',dataTarget: '#modalEquipeExcluir'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'},
                            }"
                        ></table-component>
                    </template>
                    <template v-slot:rodape>
                        <paginate-component>
                            <li v-for="l, key in equipes.links" :key="key"
                                :class="l.active ? 'page-item active' : 'page-item'"
                                @click="paginacao(l)">
                                <a class="page-link" href="#" v-html="l.label"></a></li>
                        </paginate-component>
                    </template>
                </card-component>
            </div>
        </div>
        <!-- modal -->
        <modal-component id="modalEquipe" titulo="Adicionar Equipe">
            <!-- alertas template -->
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso"
                                 v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a equipe"
                                 v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <!-- fim alertas template -->
            <!-- form modal -->
            <template v-slot:conteudo>

                <div class="form-group">
                    <!-- input nome da equipe -->
                    <input type="text" class="form-control" id="novoNome" placeholder="Nome da Equipe"
                           v-model="nomeEquipe">
                    {{ nomeEquipe }}
                    <!-- fim input nome da equipe -->
                    <!-- input imagem -->
                    <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input" id="novaImagem" lang="pt"
                               @change="carregarImagem($event)">
                        <label class="custom-file-label" for="novaImagem">Selecione uma Imagem</label>
                        {{ arquivoImagem }}
                    </div>
                    <!-- fim input imagem -->
                </div>
            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim form modal -->

        <!-- inicio modal visualização-->
        <modal-component id="modalEquipeVisualizar" titulo="Visualizar Equipe">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <!-- inicio bloco visualização-->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem"
                                         width="200" height="200" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control " id="id" :value="$store.state.item.id" disabled>
                                <label for="id">Nome da Equipe</label>
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                                <label for="id">Data de Criação</label>
                                <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- fim bloco visualização-->
            </template>

            <!-- fim modal visualização-->
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim do modal -->

        <!-- inicio modal Exclusão-->
        <modal-component id="modalEquipeExcluir" titulo="Visualizar Equipe">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <!-- inicio bloco visualização-->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem"
                                 width="200" height="200" class="rounded-circle">
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="ide">ID</label>
                                <input type="text" class="form-control " id="ide" :value="$store.state.item.id" disabled>
                                <label for="id">Nome da Equipe</label>
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- fim bloco visualização-->
            </template>

            <!-- fim modal visualização-->
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" @click="remover()">Remover</button>
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal" >Fechar</button>

                </div>
            </template>
        </modal-component>
        <!-- fim do modal Exclusão -->

    </div>
</template>

<script>
export default {
    computed: {
        token() {

            let token = document.cookie.split(';').find(indice => {
                return indice.includes('token=')
            })

            token = token.split('=')[1]
            token = 'Bearer ' + token

            return token
        }
    },
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/equipe',
            nomeEquipe: '',
            arquivoImagem: [],
            transacaoStatus: '',
            transacaoDetalhes: [],
            equipes: {
                data: []
            }
        }
    },
    methods: {
        remover() {
            let confirmacao = confirm('Tem certeza que deseja remover esse registro?')

            if(!confirmacao) {
                return false;
            }

            let formData = new FormData();
            formData.append('_method', 'delete')

            let config = {
                headers: {
                    'Accept': 'application/json',
                    'Autorization': this.token
                }
            }

            let url = this.urlBase + '/' + this.$store.state.item.id

            axios.post(url, formData, config)
                .then(response => {
                    console.log('Registro removido com sucesso', response)
                    this.carregarLista()
                })
                .catch(errors => {
                    console.log('Houve um erro na tentiva de remoção do registro', errors.response)
                })

        },
        paginacao(l) {
            if (l) {
                this.urlBase = l.url
                this.carregarLista()
            }

        },
        carregarLista() {
            axios.get(this.urlBase)
                .then(response => {
                    this.equipes = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        carregarImagem(e) {
            this.arquivoImagem = e.target.files
        },
        salvar() {
            console.log(this.nomeEquipe, this.arquivoImagem[0])

            let formData = new FormData();
            formData.append('nome', this.nomeEquipe)
            formData.append('imagem', this.arquivoImagem[0])

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
        }
    },
    mounted() {
        this.carregarLista()
    }
}
</script>
