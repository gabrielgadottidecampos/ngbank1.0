<template xmlns="http://www.w3.org/1999/html">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- -->
                <!-- Botão Adicionar ------------------------------------------------------------------------------- -->

                <div class="row">
                    <div class="col-md-6">
                        <div class="search">
                            <input type="text" placeholder="pesquisar ..." v-model="busca.nome">
                            <button type="submit" @click="pesquisar()">Pesquisar</button>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="d-md-flex justify-content-md-end">
                            <div class="wrapper"  data-toggle="modal" data-target="#modalEquipe">
                                <div class="icon facebook">
                                    <div class="tooltip" >Adicionar</div>
                                    <span><i class="fas fa-user-plus"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--fim botão adicionar ---------------------------------------------------------------------------- -->
                <card-component titulo="Equipes">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="equipes.data"
                            :visualizar="{visivel: true, dataToggle: 'modal',dataTarget: '#modalEquipeVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalEquipeAtualizar'}"
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
                    <label>Nome</label>
                    <input type="text" class="form-control" id="novoNome"
                           v-model="nomeEquipe">
                    <!-- fim input nome da equipe -->
                    <form>
                        <label>Imagem</label>
                        <div class="input-group">
                            <label class="input-group-text" for="novaImagem">Upload</label>
                            <input type="file" class="form-control"id="novaImagem" lang="pt" @change="carregarImagem($event)">
                        </div>
                    </form>


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
                                <label for="id">Id</label>
                                <input type="text" class="form-control " id="id" :value="$store.state.item.id" disabled>
                                <label for="id">Nome da Equipe</label>
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                                <label for="id">Data de Criação</label>
                                <input type="text" class="form-control" :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>
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
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
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
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal" >Fechar</button>

                </div>
            </template>
        </modal-component>
        <!-- fim do modal Exclusão -->

        <!-- modal Edição de equipe-->
        <modal-component id="modalEquipeAtualizar" titulo="Atualização Equipe">
            <!-- alertas template -->
            <template v-slot:alertas>
            </template>
            <!-- fim alertas template -->
            <!-- form modal -->
            <template v-slot:conteudo>
                <div class="form-group">
                    <!-- input nome da equipe -->
                    <label  class="form-label">Nome Da Equipe</label>
                    <input type="text" class="form-control" id="atualizarNome" placeholder="Nome da Equipe" v-model="$store.state.item.nome">
                    <!-- fim input nome da equipe -->

                    <!-- input imagem -->
                    <label  class="form-label">Imagem</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="atualizarImagem" lang="pt"
                               @change="carregarImagem($event)">
                        <label class="custom-file-label" for="atualizarImagem">Selecione uma Imagem</label>
                    </div>
                    <!-- fim input imagem -->

                </div>
            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim form modal Edição de equip -->

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
            urlPaginacao: '',
            urlFiltro: '',
            nomeEquipe: '',
            arquivoImagem: [],
            transacaoStatus: '',
            transacaoDetalhes: [],
            equipes: {
                data: []
            },
            busca:{
                nome: ''
            }
        }
    },
    methods: {
    // metodo pesquisar ************************************************************************************************
        pesquisar() {

          let filtro = '';
          for(let chave in this.busca)
              if(this.busca[chave]) {

                  filtro += chave + ':like:' + this.busca[chave]

          }
          if(filtro != '') {
              this.urlPaginacao = 'page=1'
              this.urlFiltro = '&filtro='+ filtro +'%'
          } else {
              this.urlFiltro = ''
          }
            this.carregarLista()
        },
    // fim do metodo pesquisar -----------------------------------------------------------------------------------------
        paginacao(l) {
            if(l.url) {
                //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarLista() //requisitando novamente os dados para nossa API
            }
        },
        atualizar(){
            let formData = new FormData();
            formData.append('_method', 'patch')
            formData.append('nome', this.$store.state.item.nome)

            if(this.arquivoImagem[0]) {
                formData.append('imagem', this.arquivoImagem[0])
            }

            let url = this.urlBase + '/' + this.$store.state.item.id

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'Autorization': this.token
                }
            }

            axios.post(url, formData, config)
                .then(response => {
                    console.log('Atualizado', response)
                    //limpar o campo de seleção de arquivos
                    atualizarImagem.value = ''
                    this.carregarLista()
                })
                .catch(errors => {
                    console.log('Erro de atualização', errors.response)
                })
        },
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

                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = response.data.msg
                    this.carregarLista()
                })
                .catch(errors => {
                    console.log('Houve um erro na tentiva de remoção do registro', errors.response)
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.erro
                })

        },

        carregarLista() {
            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro
            console.log(url)
            axios.get(url)
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
                    this.limpar()
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                    this.carregarLista()
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
        },
        limpar(){
            this.nomeEquipe = '',
            this.arquivoImagem = []
        }
    },
    mounted() {
        this.carregarLista()
    }
}
</script>
<style>
/*
    Auther: Abdelrhman Said
*/

@import url("https://fonts.googleapis.com/css2?family=Poppins&display=swap");

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

*:focus,
*:active {
    outline: none !important;
    -webkit-tap-highlight-color: transparent;
}


.wrapper {
    display: inline-flex;
}

.wrapper .icon {
    position: relative;
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    padding: 15px;
    margin: 10px;
    width: 50px;
    height: 50px;
    font-size: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .tooltip {
    position: absolute;
    top: 0;
    font-size: 14px;
    background-color: #ffffff;
    color: #ffffff;
    padding: 5px 8px;
    border-radius: 5px;
    box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
    opacity: 0;
    pointer-events: none;
    transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.wrapper .icon:hover .tooltip {
    top: -45px;
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.wrapper .icon:hover span,
.wrapper .icon:hover .tooltip {
    text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
}

.wrapper .facebook:hover,
.wrapper .facebook:hover .tooltip,
.wrapper .facebook:hover .tooltip::before {
    background-color: #38c172;
    color: #ffffff;
}

</style>
