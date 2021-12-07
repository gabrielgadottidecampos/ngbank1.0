<template>
    <div class="container">
        <!-- Botão Adicionar ------------------------------------------------------------------------------- -->


        <div class="row">
            <div class="col-md-6">
                <form class=" search" action="">
                    <input type="search" placeholder="Search here..." required>
                    <button type="submit">Search</button>
                </form>
            </div>
            <div class="col-md-6">
                <div class="d-md-flex justify-content-md-end mb-2">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalEquipe">
                        <i class="fas fa-user-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--fim botão adicionar ---------------------------------------------------------------------------- -->
        <!-- inicio card componente *********************************************************************************-->
        <card-component titulo="Funcionarios">
            <!-- inicio do conteudo do card *************************************************************************-->
            <template v-slot:conteudo>
                <table-component
                    :dados="funcionarios.data"
                    :visualizar="{visivel: true, dataToggle: 'modal',dataTarget: '#modalFuncionarioVisualizar'}"
                    :atualizar="{visivel: true, dataToggle: 'modal',dataTarget: '#modalFuncionarioAtualizar'}"
                    :remover="{visivel: true, dataToggle: 'modal',dataTarget: '#modalFuncionarioExcluir'}"
                    :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                equipe:{titulo: 'Equipe', tipo: 'nomeEquipe'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                data_nascimento:{titulo: 'Data Nascimento',tipo:'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'},
                            }">

                </table-component>

            </template>
            <!-- fim do conteudo do card ------------------------------------------------------------------------------>
            <!-- inicio do conteudo do rodape ***********************************************************************-->
            <template v-slot:rodape>
                <paginate-component>
                    <li v-for="l, key in funcionarios.links" :key="key"
                        :class="l.active ? 'page-item active' : 'page-item'"
                        @click="paginacao(l)">
                        <a class="page-link" href="#" v-html="l.label"></a></li>
                </paginate-component>
            </template>
            <!-- fim do card do rodape -------------------------------------------------------------------------------->
        </card-component>
        <!-- fim card componente ************************************************************************************-->
        <!-- modal adicionar Funcionario ******************************************************************************* -->
        <modal-component id="modalEquipe" titulo="Adicionar Funcionario">
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
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" placeholder="Digite um nome" v-model="nomeFuncionario">
                </div>
                <div class="mb-3">
                    <label class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control" placeholder="Digite a data de nascimento"
                           v-model="data_nascimento">
                </div>
                <form>
                    <label>Imagem</label>
                    <div class="input-group">
                        <label class="input-group-text" for="novaImagem">Upload</label>
                        <input type="file" class="form-control" id="novaImagem" lang="pt"
                               @change="carregarImagem($event)">
                    </div>
                </form>

                <form>
                    <div class="form-group">
                        <label>Equipes</label>
                        <select class="form-control" @change="onChangeMethod($event)">
                            <option selected>Selecione uma Equipe</option>
                            <option v-for="option in teste.data" v-bind:value="option.id">{{ option.nome }}</option>
                        </select>
                    </div>
                </form>
            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-success" @click="salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim form modal adicionar funcionario ------------------------------------------------------------------------->
        <!-- modal Editar Funcionario *************************************************************************** -->
        <!-- modal Edição de equipe-->
        <modal-component id="modalFuncionarioAtualizar" titulo="Atualização Funcionario">
            <!-- alertas template -->
            <template v-slot:alertas>
            </template>
            <!-- fim alertas template -->
            <!-- form modal -->
            <template v-slot:conteudo>
                <div class="form-group">
                    <!-- input nome da equipe -->
                    <label>Nome Do Funcionario</label>
                    <input type="text" class="form-control" id="atualizarNome" placeholder="Nome do Funcionario"
                           v-model="$store.state.item.nome">
                    <!-- fim input nome da equipe -->
                    <label>Data de Nascimento</label>
                    <input type="date" class="form-control" id="atualizarDataNascimento"
                           placeholder="Nascimento Funcionario" v-model="$store.state.item.data_nascimento">
                    <label>Nome Da Equipe</label>
                    <input type="text" class="form-control" id="atualizarEquipe" placeholder="Nascimento Funcionario"
                           v-model="$store.state.item.equipe.nome">

                    <select class="form-control" @change="onChangeMethod($event)" v-bind:value="$store.state.item.data_nascimento">
                        <option ></option>
                        <option >
                            oi
                        </option>
                    </select>

                    <!-- input imagem -->
                    <label>Imagem</label>
                    <div class="custom-file ">
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
        <!-- fim form modal Editar funcionario --------------------------------------------------------------------->
        <!-- inicio modal de visualizar equipe **********************************************************************-->
        <modal-component id="modalFuncionarioVisualizar" titulo="Visualizar Funcionario">
            <template v-slot:alertas></template>
            <template v-slot:conteudo>
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem"
                                     width="200" height="200" class="rounded-circle">
                            </div>
                        </div>
                        <div class="col">
                            <label for="id">ID</label>
                            <input type="text" class="form-control " id="id" :value="$store.state.item.id" disabled>
                            <label for="id">Nome do Funcionario</label>
                            <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                            <label for="id">Data de Nascimento</label>
                            <input type="text" class="form-control" :value="$store.state.item.data_nascimento" disabled>
                            <label for="id">Equipe</label>
                            <input type="text" class="form-control" :value="$store.state.item.equipe.nome" disabled>
                            <label for="id">Data de Criação</label>
                            <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                        </div>
                    </div>

                </div>
            </template>

            <!-- fim modal visualização-->
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-dismiss="modal">Fechar</button>
                </div>
            </template>
        </modal-component>
        <!-- Fim modal de visualizar equipe --------------------------------------------------------------------------->
        <!-- inicio modal Exclusão-->
        <modal-component id="modalFuncionarioExcluir" titulo="Visualizar Funcionario">
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
                            <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem"
                                 width="200" height="200" class="rounded-circle">
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="ide">ID</label>
                                <input type="text" class="form-control " id="ide" :value="$store.state.item.id"
                                       disabled>
                                <label for="id">Nome da Equipe</label>
                                <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                                <label for="id">Nome da Equipe</label>
                                <input type="text" class="form-control" :value="$store.state.item.data_nascimento"
                                       disabled>
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
    </div>
</template>
<!-- inicio dos scripts *********************************************************************************************-->
<script>
import Paginate from "./Paginate";
export default {
    components: {Paginate},
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
// fim evitando erro de token no navegador -----------------------------------------------------------------------------
// inicio Data *********************************************************************************************************
    data() {
        return {
            urlBase: 'http://127.0.0.1:8000/api/v1/equipe',
            urlBaseFuncionario: 'http://127.0.0.1:8000/api/v1/funcionario',
            teste: [],
            arquivoImagem: [],
            equipe_id: [],
            nomeFuncionario: '',
            data_nascimento: [],
            transacaoDetalhes: [],
            transacaoStatus: '',
            funcionarios: [],
            equipe: [],

        }
    },
// Fim Data ------------------------------------------------------------------------------------------------------------
// inicio metodos ******************************************************************************************************
    methods: {
// função carregar lista ***********************************************************************************************
        carregarLista() {
            axios.get(this.urlBase)
                .then(response => {
                    console.log(this.teste = response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        onChangeMethod(event) {
            //  console.log(event.target.value);
            this.equipe_id = event.target.value;
            console.log(this.equipe_id);

        },
// fim função carregar lista -------------------------------------------------------------------------------------------
// inicio função listar funcionario ************************************************************************************
        carregarListaFuncionario() {
            axios.get(this.urlBaseFuncionario)
                .then(response => {
                    console.log(this.funcionarios = response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
// fim função listar funcionario ---------------------------------------------------------------------------------------
// carregar imagem *****************************************************************************************************
        carregarImagem(e) {
            this.arquivoImagem = e.target.files
        },
// fim carregar imagens ------------------------------------------------------------------------------------------------


// Salvar **************************************************************************************************************
        salvar() {
            console.log(this.nomeFuncionario, this.data_nascimento, this.arquivoImagem, this.equipe_id)
            let formData = new FormData();
            formData.append('equipe_id', this.equipe_id)
            formData.append('nome', this.nomeFuncionario)
            formData.append('imagem', this.arquivoImagem[0])
            formData.append('data_nascimento', this.data_nascimento)
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }

            axios.post(this.urlBaseFuncionario, formData, config)
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

// fim Salvar ----------------------------------------------------------------------------------------------------------

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

            let url = this.urlBaseFuncionario + '/' + this.$store.state.item.id

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
    },
//Fim Metodos-----------------------------------------------------------------------------------------------------------
    mounted() {
        this.carregarLista();
        this.carregarListaFuncionario()
    }
}
</script>
