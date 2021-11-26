<template>
    <div class="container">
        <!-- Botão Adicionar ------------------------------------------------------------------------------- -->
        <div class="d-md-flex justify-content-md-end mb-2">
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalVenda">
                <i class="fas fa-cart-arrow-down"></i>
            </button>
        </div>
        <!--fim botão adicionar ---------------------------------------------------------------------------- -->

        <card-component titulo="Vendas">
            <template v-slot:conteudo>
                <table-component :dados="vendas"
                                 :visualizar="{visivel: true , dataToggle: 'modal',dataTarget: '#modalVendaVisualizar'}"
                                 :atualizar="{visivel: true, dataToggle: 'modal',dataTarget: '#modalVendaAtualizar'}"
                                 :remover="{visivel: true, dataToggle: 'modal',dataTarget: '#modalVendaExcluir'}"
                                 :titulos="{
                                     id: {titulo: 'ID', tipo: 'texto'},
                                     funcionario:{titulo: 'Funcionario', tipo: 'nomeEquipe'},
                                     valor_venda: {titulo: 'Valor da Venda', tipo: 'texto'},
                                     created_at: {titulo: 'Data da Venda', tipo: 'data'},
                            }">

                </table-component>

            </template>
            <template v-slot:rodape>
            </template>
        </card-component>

        <!-- modal Vendas adicionar ------------------------------------------------------------------------------------>
        <modal-component id="modalVenda" titulo="Adicionar Venda">
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
                <div class="mb-3">
                    <label class="form-label">Funcionario</label>
                    <input type="text" class="form-control" placeholder="Digite um nome" v-model="nomeFuncionario">
                </div>
                <div class="mb-3">
                    <label class="form-label">Valor</label>
                    <input type="text" class="form-control" placeholder="Valor" v-model="valor_venda">
                </div>
                <div class="input-group mb-6 mt-3">
                    <label class="input-group-text">Funcionario</label>
                    <select class="form-select " @change="onChangeMethod($event)">
                        <option selected>Selecione um Funcionario</option>
                        <option v-for="option in teste" v-bind:value=" option.id " :key="option.id"
                                :ref="option.equipe_id">{{ option.nome }}
                        </option>
                    </select>
                    {{ refsss }}
                </div>


            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
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
                                <img :src="'storage/'+$store.state.item.funcionario.imagem" v-if="$store.state.item.funcionario.imagem"
                                     width="200" height="200" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="id">Nome</label>
                                <input type="text" class="form-control " :value="$store.state.item.funcionario.nome"
                                       disabled>
                                <label for="id">Valor da Venda</label>
                                <input type="text" class="form-control" :value="$store.state.item.valor_venda" disabled>
                                <label for="id">Data da Venda</label>
                                <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>

                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </modal-component>
        <!-- fim modal visualizar vendas ------------------------------------------------------------------------------>

        <!-- inicio modal Exclusão-->
        <modal-component id="modalVendaExcluir" titulo="Visualizar Funcionario">
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
                                <img :src="'storage/'+$store.state.item.funcionario.imagem" v-if="$store.state.item.funcionario.imagem"
                                     width="200" height="200" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="id">ID</label>
                                <input type="text" class="form-control " id="id" :value="$store.state.item.id"
                                       disabled>
                                <label for="id">Nome</label>
                                <input type="text" class="form-control " id="id" :value="$store.state.item.funcionario.nome"
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
                    <input type="text" class="form-control" v-model="$store.state.item.valor_venda">
                    <label for="id">Data da Venda</label>
                    <input type="text" class="form-control" v-model="$store.state.item.created_at" >
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
            equipe_id: [],
            funcionario_id: [],
            valor_venda: '',
            nomeFuncionario: '',
            teste: [],
            refsss: [],
            vendas: []
        }
    },
    // fim Data *********************************************************************************************************
    // Salvar **************************************************************************************************************
    methods: {
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
            this.equipe_id = event.target.value;
            console.log(this.equipe_id);
            this.refsss = this.$refs


        },
        // fim Listar funcionario --------------------------------------------------------------------------------------
        // listar Vendas ***********************************************************************************************
        carregarListaVenda() {
            axios.get(this.urlBaseVenda)
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

// Fim remover Venda ---------------------------------------------------------------------------------------------
    },
    mounted() {

        //  this.carregarFuncionarioLista()
        this.carregarListaVenda()
    }
}
</script>
