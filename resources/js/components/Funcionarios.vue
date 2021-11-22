<template>
    <div class="container">
        <!-- Botão Adicionar ------------------------------------------------------------------------------- -->
        <div class="d-md-flex justify-content-md-end mb-2">
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalEquipe">
                <i class="fas fa-user-plus"></i>
            </button>
        </div>
        <!--fim botão adicionar ---------------------------------------------------------------------------- -->
        <!-- inicio card componente *********************************************************************************-->
        <card-component titulo="Funcionarios">
            <!-- inicio do conteudo do card *************************************************************************-->
            <template v-slot:conteudo>
                <table-component
                    :dados="funcionarios"
                    :visualizar="{visivel: true}"
                    :atualizar="{visivel: true}"
                    :remover="{visivel: true}"
                    :titulos="{
                                id: {titulo: 'ID', tipo: 'texto'},
                                nome: {titulo: 'Nome', tipo: 'texto'},
                                data_nascimento:{titulo: 'Data Nascimento',tipo:'texto'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                created_at: {titulo: 'Criação', tipo: 'data'},
                            }">

                </table-component>

                {{funcionarios.data}}
            </template>
            <!-- fim do conteudo do card ------------------------------------------------------------------------------>
            <!-- inicio do conteudo do rodape ***********************************************************************-->
            <template v-slot:rodape>

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
                    {{ nomeFuncionario }}
                </div>
                <div class="mb-3">
                    <label class="form-label">Data de Naascimento</label>
                    <input type="text" class="form-control" placeholder="Digite a data de nascimento"
                           v-model="data_nascimento">
                    {{ data_nascimento }}
                </div>

                <div class="custom-file mt-3">
                    <input type="file" class="custom-file-input" id="novaImagem" lang="pt"
                           @change="carregarImagem($event)">
                    <label class="custom-file-label" for="novaImagem">Selecione uma Imagem</label>
                    {{ arquivoImagem }}
                </div>

                <div class="input-group mb-6 mt-3">
                    <label class="input-group-text">Equipes</label>
                    <select class="form-select " @change="onChangeMethod($event)">
                        <option selected>Selecione uma Equipe</option>
                        <option v-for="option in teste.data" v-bind:value="option.id">{{ option.nome }}</option>
                    </select>
                </div>

            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-success" @click="salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim form modal adicionar funcionario ------------------------------------------------------------------------->
    </div>
</template>
<!-- inicio dos scripts *********************************************************************************************-->
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
            equipe:[],

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
    },
//Fim Metodos-----------------------------------------------------------------------------------------------------------
    mounted() {
        this.carregarLista();
        this.carregarListaFuncionario()
    }
}
</script>
