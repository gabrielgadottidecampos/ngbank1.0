<template>
    <div class="container">
        <!-- Botão Adicionar ------------------------------------------------------------------------------- -->
        <div class="row">
            <div class="col-md-6">
                <div class="search">
                    <input type="text" placeholder="pesquisar ..."v-model="busca.id">
                    <button type="submit" @click="pesquisar()">Pesquisar</button>
                </div>

            </div>
            <div class="col-md-6">
                <div class="d-md-flex justify-content-md-end">
                    <button class="button1" data-toggle="modal" data-target="#modalVenda" @click="carregarFuncionarioLista()">
  <span class=" button__text">
                    <span>V</span><span>E</span>N</span><span>D</span><span>A</span>
                        <svg class="button__svg" role="presentational" viewBox="0 0 600 600">
                            <defs>
                                <clipPath id="myClip">
                                    <rect x="0" y="0" width="100%" height="50%"/>
                                </clipPath>
                            </defs>
                            <g clip-path="url(#myClip)">
                                <g id="money">
                                    <path
                                        d="M441.9,116.54h-162c-4.66,0-8.49,4.34-8.62,9.83l.85,278.17,178.37,2V126.37C450.38,120.89,446.56,116.52,441.9,116.54Z"
                                        fill="#699e64" stroke="#323c44" stroke-miterlimit="10" stroke-width="14"/>
                                    <path
                                        d="M424.73,165.49c-10-2.53-17.38-12-17.68-24H316.44c-.09,11.58-7,21.53-16.62,23.94-3.24.92-5.54,4.29-5.62,8.21V376.54H430.1V173.71C430.15,169.83,427.93,166.43,424.73,165.49Z"
                                        fill="#699e64" stroke="#323c44" stroke-miterlimit="10" stroke-width="14"/>
                                </g>
                                <g id="creditcard">
                                    <path
                                        d="M372.12,181.59H210.9c-4.64,0-8.45,4.34-8.58,9.83l.85,278.17,177.49,2V191.42C380.55,185.94,376.75,181.57,372.12,181.59Z"
                                        fill="#a76fe2" stroke="#323c44" stroke-miterlimit="10" stroke-width="14"/>
                                    <path
                                        d="M347.55,261.85H332.22c-3.73,0-6.76-3.58-6.76-8v-35.2c0-4.42,3-8,6.76-8h15.33c3.73,0,6.76,3.58,6.76,8v35.2C354.31,258.27,351.28,261.85,347.55,261.85Z"
                                        fill="#ffdc67"/>
                                    <path d="M249.73,183.76h28.85v274.8H249.73Z" fill="#323c44"/>
                                </g>
                            </g>
                            <g id="wallet">
                                <path
                                    d="M478,288.23h-337A28.93,28.93,0,0,0,112,317.14V546.2a29,29,0,0,0,28.94,28.95H478a29,29,0,0,0,28.95-28.94h0v-229A29,29,0,0,0,478,288.23Z"
                                    fill="#a4bdc1" stroke="#323c44" stroke-miterlimit="10" stroke-width="14"/>
                                <path
                                    d="M512.83,382.71H416.71a28.93,28.93,0,0,0-28.95,28.94h0V467.8a29,29,0,0,0,28.95,28.95h96.12a19.31,19.31,0,0,0,19.3-19.3V402a19.3,19.3,0,0,0-19.3-19.3Z"
                                    fill="#a4bdc1" stroke="#323c44" stroke-miterlimit="10" stroke-width="14"/>
                                <path d="M451.46,435.79v7.88a14.48,14.48,0,1,1-29,0v-7.9a14.48,14.48,0,0,1,29,0Z"
                                      fill="#a4bdc1" stroke="#323c44" stroke-miterlimit="10" stroke-width="14"/>
                                <path
                                    d="M147.87,541.93V320.84c-.05-13.2,8.25-21.51,21.62-24.27a42.71,42.71,0,0,1,7.14-1.32l-29.36-.63a67.77,67.77,0,0,0-9.13.45c-13.37,2.75-20.32,12.57-20.27,25.77l.38,221.24c-1.57,15.44,8.15,27.08,25.34,26.1l33-.19c-15.9,0-28.78-10.58-28.76-25.93Z"
                                    fill="#7b8f91"/>
                                <path d="M148.16,343.22a6,6,0,0,0-6,6v92a6,6,0,0,0,12,0v-92A6,6,0,0,0,148.16,343.22Z"
                                      fill="#323c44"/>
                            </g>

                        </svg>
                    </button>

                </div>
            </div>
        </div>
        <!--fim botão adicionar ---------------------------------------------------------------------------- -->

        <card-component titulo="Vendas">
            <template v-slot:conteudo>
                <table-component :dados="vendas.data"
                                 :visualizar="{visivel: true , dataToggle: 'modal',dataTarget: '#modalVendaVisualizar'}"
                                 :atualizar="{visivel: true, dataToggle: 'modal',dataTarget: '#modalVendaAtualizar'}"
                                 :remover="{visivel: true, dataToggle: 'modal',dataTarget: '#modalVendaExcluir'}"
                                 :titulos="{
                                     id: {titulo: 'ID', tipo: 'texto'},
                                     funcionario:{titulo: 'Funcionario', tipo: 'nomeFuncionario'},
                                     valor_venda: {titulo: 'Valor da Venda', tipo: 'valor'},
                                     created_at: {titulo: 'Data da Venda', tipo: 'data'},
                            }">
                </table-component>

            </template>
            <template v-slot:rodape>
                <paginate-component>
                    <li v-for="l, key in vendas.links" :key="key"
                        :class="l.active ? 'page-item active' : 'page-item'"
                        @click="paginacao(l)">
                        <a class="page-link" href="#" v-html="l.label"></a></li>
                </paginate-component>
            </template>

        </card-component>

        <!-- modal Vendas adicionar ------------------------------------------------------------------------------------>
        <modal-component id="modalVenda " titulo="Adicionar Venda">
            <!-- alertas template -->
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso"
                                 v-if="transacaoStatus == 'adicionado'">

                </alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a equipe"
                                 v-if="transacaoStatus == 'erro'">

                </alert-component>
            </template>
            <!-- fim alertas template -->
            <!-- form modal -->
            <template v-slot:conteudo>
                <div class="form-group">
                    <label>Funcionario</label>
                    <select class="form-control" @change="onChangeMethod($event)">
                        <option v-if="a == ''" value="0" selected>Selecione um Funcionario</option>
                        <option v-for="option in teste.data" v-bind:value=" option.id " :key="option.id">
                            {{ option.nome }}
                        </option>
                    </select>
                </div>
                <form>
                    <div class="form-group">
                        <label>Equipe</label>
                        <select class="form-control" @change="onChangeMethod1($event)">
                            <option>Equipe</option>
                            <option v-for="option in teste.data" v-if="option.id == a" v-bind:value="option.equipe_id">
                                {{ option.equipe.nome }}
                            </option>
                        </select>
                    </div>
                </form>
                <label class="form-label">Valor</label>
                <div class="input-group mb-3">
                    <span class="input-group-text">R$</span>
                    <input type="number" min="0.01" step="0.01" max="9999999" class="form-control" placeholder="Valor"
                           v-model="valor_venda">
                </div>
            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" @click="limpalista()">
                        Fechar
                    </button>
                    <button type="button" class="btn btn-outline-success" @click="salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim modal Vendas adicionar -------------------------------------------------------------------------------->
        <!-- modal visualizar vendas ********************************************************************************-->
        <modal-component id="modalVendaVisualizar" titulo="Visualizar Venda">
            <template v-slot:alertas>

            </template>
            <template v-slot:conteudo>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <img :src="'storage/'+$store.state.item.funcionario.imagem"
                                     v-if="$store.state.item.funcionario.imagem"
                                     width="200" height="200" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="id">Nome</label>
                                <input type="text" class="form-control " :value="$store.state.item.funcionario.nome"
                                       disabled>
                                <label for="id">Valor da Venda</label>
                                <input type="text" class="form-control" :value="$store.state.item.valor_venda "
                                       disabled>
                                <label for="id">Data da Venda</label>
                                <input type="text" class="form-control"
                                       :value="$store.state.item.created_at | formataDataTempoGlobal" disabled>

                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </modal-component>
        <!-- fim modal visualizar vendas ------------------------------------------------------------------------------>

        <!-- inicio modal Exclusão-->
        <modal-component id="modalVendaExcluir" titulo="Excluir Venda">
            <template v-slot:alertas>
                <alert-component tipo="success" titulo="Transação realizada com sucesso"
                                 :detalhes="$store.state.transacao" v-if="$store.state == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao"
                                 v-if="$store.state == 'erro'"></alert-component>
            </template>
            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <!-- inicio bloco visualização-->
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <img :src="'storage/'+$store.state.item.funcionario.imagem"
                                     v-if="$store.state.item.funcionario.imagem"
                                     width="200" height="200" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control " id="id" :value="$store.state.item.id"
                                       disabled>
                                <label for="id">Nome</label>
                                <input type="text" class="form-control " id="id"
                                       :value="$store.state.item.funcionario.nome"
                                       disabled>
                                <label for="id">Valor da Venda</label>
                                <input type="text" class="form-control" :value="$store.state.item.valor_venda" disabled>
                                <label for="id">Data da Venda</label>
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
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal" @click="remover()"
                            v-if="$store.state.transacao.status != 'sucesso'">Remover
                    </button>
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>

                </div>
            </template>
        </modal-component>
        <!-- fim do modal Exclusão -->

        <!-- modal Edição de equipe-->
        <modal-component id="modalVendaAtualizar" titulo="Atualização Funcionario">
            <!-- alertas template -->
            <template v-slot:alertas>
            </template>
            <!-- fim alertas template -->
            <!-- form modal -->
            <template v-slot:conteudo>
                <div class="form-group">
                    <label for="id">Equipe ID</label>
                    <input type="text" class="form-control " :value="$store.state.item.funcionario.equipe_id"
                           disabled>
                    <label for="id">funcionario id</label>
                    <input type="text" class="form-control " :value="$store.state.item.funcionario.id"
                           disabled>
                    <label for="id">Nome</label>
                    <input type="text" class="form-control " :value="$store.state.item.funcionario.nome" disabled>
                    <label for="id">Valor da Venda</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">R$</span>
                        <input type="number" min="0.01" step="0.01" max="9999999" class="form-control"
                               placeholder="Valor"
                               v-model="$store.state.item.valor_venda">
                    </div>
                    <label for="id">Data da Venda</label>
                    <input type="date" class="form-control" v-model="$store.state.item.created_at">

                </div>
                {{ formatandoData() }} -- aqui
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
// evitando erro de token no navegador *********************************************************************************
        token() {
            let token = document.cookie.split(';').find(indice => {
                return indice.includes('token=')
            })
            token = token.split('=')[1]
            token = 'Bearer ' + token
            return token
        }
    },
    // inicio Data *********************************************************************************************************
    data() {
        return {
            transacaoDetalhes: [],
            transacaoStatus: '',
            urlBaseVenda: 'http://127.0.0.1:8000/api/v1/venda',
            urlBaseFuncionario: 'http://127.0.0.1:8000/api/v1/funcionario',
            urlPaginacao: '',
            urlFiltro: '',
            equipe_id: [],
            funcionario_id: [],
            valor_venda: '',
            nomeFuncionario: '',
            teste: [],
            refsss: [],
            vendas: [],
            a: '',
            equipe: '',
            b: '',
            busca:{
                id: ''
            }
        }
    },
    // fim Data *********************************************************************************************************
    // Salvar **************************************************************************************************************
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
            this.carregarListaVenda()
        },
        paginacao(l) {
            if(l.url) {
                //this.urlBase = l.url //ajustando a url de consulta com o parâmetro de página
                this.urlPaginacao = l.url.split('?')[1]
                this.carregarListaVenda() //requisitando novamente os dados para nossa API
            }
        },
        salvar() {
            let formData = new FormData();
            formData.append('equipe_id', this.equipe_id)
            formData.append('funcionario_id', this.funcionario_id)
            formData.append('valor_venda', this.valor_venda)
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }
            axios.post(this.urlBaseVenda, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.limpalista()
                    this.carregarListaVenda()
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id,
                    }
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.message,
                        dados: errors.response.data.errors
                    }
                })
        },
        // fim Salvar --------------------------------------------------------------------------------------------------
        // Listar funcionario ******************************************************************************************
        carregarFuncionarioLista() {
            axios.get(this.urlBaseFuncionario)
                .then(response => {
                    console.log(this.teste = response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        onChangeMethod(event) {
            this.a = event.target.value;
            this.funcionario_id = this.a
            console.log(this.funcionario_id)
        },
        onChangeMethod1(event) {
            console.log(event.target.value)
            this.equipe = event.target.value
            this.equipe_id = this.equipe
        },
        limpalista() {
            this.a = ''
            this.funcionario_id = ''
            this.equipe_id = ''
            this.valor_venda = ''
        },
        // fim Listar funcionario --------------------------------------------------------------------------------------
        // listar Vendas ***********************************************************************************************
        carregarListaVenda() {
            let url = this.urlBaseVenda + '?' + this.urlPaginacao + this.urlFiltro
            console.log(url)
            axios.get(url)
                .then(response => {
                    console.log(this.vendas = response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        // fim listar vendas -------------------------------------------------------------------------------------------
        // Remover Vebda *************************************************************************************************
        remover() {
            let confirmacao = confirm('Tem certeza que deseja remover esse registro?')
            if (!confirmacao) {
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
            let url = this.urlBaseVenda + '/' + this.$store.state.item.id
            axios.post(url, formData, config)
                .then(response => {
                    console.log('Registro removido com sucesso', response)
                    this.$store.state.transacao.status = 'sucesso'
                    // this.$store.state.transacao.mensagem = response.data.msg
                    this.carregarListaVenda()
                })
                .catch(errors => {
                    console.log('Houve um erro na tentiva de remoção do registro', errors.response)
                    this.$store.state.transacao.status = 'erro'
                    //this.$store.state.transacao.mensagem = errors.response.data.erro
                })
        },
        // função atualizar funcionario ****************************************************************************************
        atualizar() {
            console.log(this.$store.state.item.funcionario.equipe_id)
            console.log(this.$store.state.item.funcionario.id)
            console.log(this.$store.state.item.valor_venda)
            let url = this.urlBaseVenda + '/' + this.$store.state.item.id
            console.log(url)
            let formData = new FormData();
            formData.append('_method', 'patch')
            formData.append('equipe_id', this.$store.state.item.funcionario.equipe_id)
            formData.append('funcionario_id', this.$store.state.item.funcionario.id)
            formData.append('valor_venda', this.$store.state.item.valor_venda)
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
                    this.carregarListaFuncionario()
                    atualizarImagem.value = ''
                })
                .catch(errors => {
                    console.log('Erro de atualização', errors.response)
                })
        },
// fim função atualizar funcionario ------------------------------------------------------------------------------------
        formatandoData() {
            return Date.parse(this.$store.state.item.created_at);
        }
// Fim remover Venda ---------------------------------------------------------------------------------------------
    },
    mounted() {
        this.carregarListaVenda();
        this.carregarFuncionarioLista()
    }
}
</script>
<style>
.search {
    width: 500px;
    height: 40px;
    margin: 10px 1px;
    background: #444;
    background: rgba(0, 0, 0, 0.2);
    border-radius: 3px;
    border: 1px solid #fff;
}
.search input {
    width: 370px;
    padding: 10px 5px;
    float: left;
    color: #ccc;
    border: 0;
    background: transparent;
    border-radius: 3px 0 0 3px;
}
.search input:focus {
    outline: 0;
    background: transparent;
}
.search button {
    position: relative;
    float: right;
    border: 0;
    padding: 0;
    cursor: pointer;
    height: 40px;
    width: 120px;
    color: #c2a925;
    background: transparent;
    border-left: 1px solid #fff;
    border-radius: 0 3px 3px 0;
}
.search button:hover {
    background: rgba(194,169, 37, 0.3);
    color: #fffdfd;
}
.search button:active {
    box-shadow: 0px 0px 12px 0px #e1e1e1;
}
.search button:focus {
    outline: 0;
}
/* only animate if the device supports hover */
@media (hover: hover) {
    #creditcard {
        /*  set start position */
        transform: translateY(110px);
        transition: transform 0.1s ease-in-out;
        /*  set transition for mouse enter & exit */
    }
    #money {
        /*  set start position */
        transform: translateY(180px);
        transition: transform 0.1s ease-in-out;
        /*  set transition for mouse enter & exit */
    }
    button:hover #creditcard {
        transform: translateY(0px);
        transition: transform 0.2s ease-in-out;
        /*  overide transition for mouse enter */
    }
    button:hover #money {
        transform: translateY(0px);
        transition: transform 0.3s ease-in-out;
        /*  overide transition for mouse enter */
    }
}
@keyframes bounce {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-0.25rem);
    }
    100% {
        transform: translateY(0);
    }
}
.button:hover .button__text span {
    transform: translateY(-0.25rem);
    transition: transform .2s ease-in-out;
}
/* styling */
@import url("https://fonts.googleapis.com/css2?family=Lato:wght@300;400&display=swap");
.button1 {
    border: none;
    outline: none;
    background-color: purple;
    padding: 1rem 90px 1rem 2rem;
    position: relative;
    border-radius: 70px;
    letter-spacing: 0.7px;
    background-color: rgba(0, 9, 61, 0);
    color: #fff;
    font-size: 21px;
    font-family: "Lato", sans-serif;
    cursor: pointer;
    box-shadow: rgba(0, 9, 61, 0.2) 0px 4px 8px 0px;
}
.button:active {
    transform: translateY(1px);
}
.button__svg {
    position: absolute;
    overflow: visible;
    bottom: 6px;
    right: 0.2rem;
    height: 140%;
}
</style>
