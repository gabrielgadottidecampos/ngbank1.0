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
                        <option v-for="option in teste" v-bind:value=" option.id " :key="option.id" :ref="option.equipe_id" >{{ option.nome }}</option>
                    </select>
                    {{refsss}}
                </div>


            </template>
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-outline-success" @click="salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
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
            refsss: []
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
            this.refsss =this.$refs


        },
        // fim Listar funcionario --------------------------------------------------------------------------------------
    },
    mounted() {

        this.carregarFuncionarioLista()
    }
}
</script>
