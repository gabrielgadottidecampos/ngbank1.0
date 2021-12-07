<template>
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-10 ">
                <div class="cardEquipe m-b-30">
                    <div class="card-header corDaImagem">
                        <h3 class="card-title text-black mb-0 text-center">
                            Equipe Camarote</h3>
                    </div>
                    <div class="card-body">
                        <div class="xp-social-profile">
                            <div class="xp-social-profile-img" >
                                <div class="row" >
                                    <div class="col-2 px-1 mt-2" v-for="t in VendasFiltro(0, vendas, 6, 1)">
                                        <img v-bind:src="/storage/+t.imagem" class="rounded img-fluid border" alt="img" width="200" height="200">
                                    </div>
                                </div>
                            </div>
                            <div class="xp-social-profile-top">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="xp-social-profile-star py-3">
                                            <i class="mdi mdi-star font-24"></i>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="xp-social-profile-avatar text-center">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="user-profile" class="rounded-circle img-fluid">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="xp-social-profile-menu text-right py-3">
                                            <i class="mdi mdi-dots-horizontal font-24"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="xp-social-profile-middle text-center">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="xp-social-profile-title">
                                            <h5 class="my-1 text-black">Nome da Equipe</h5>
                                        </div>
                                        <div class="xp-social-profile-desc">
                                            <p class="text-muted">Total De Vendas</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="xp-social-profile-bottom text-center">
                                <div class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    data() {
        return {
            urlBaseVenda: 'http://127.0.0.1:8000/api/v1/venda', // url para chamar a api de vendas
            urlBaseFuncionario: 'http://127.0.0.1:8000/api/v1/funcionario', // url para chamar a api de funcionario
            vendas: [],
            funcionarios: []
        }
    },
// inicio dos metodos **************************************************************************************************
    methods: {
// trazer as informações da api de venda *******************************************************************************
        CarregarApiVendas() {
            axios.get(this.urlBaseVenda)
                .then(response => {
                    console.log(this.vendas = response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
// fim trazer as informações da api de venda ---------------------------------------------------------------------------
        CarregarApiFuncionarios() {
            axios.get(this.urlBaseFuncionario)
                .then(response => {
                    console.log(this.funcionarios = response.data)
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
// carregar informações funcionario ************************************************************************************

// Fim carregar informações funcionario --------------------------------------------------------------------------------

// Funcção para ordenar e definir quantidade do vetor ******************************************************************
        OrdenarVetor(quantidade, array) { // quantidade: a quantidade que ira retornar, array: array que irá receber
            var arrayRecebido = array; // salva o array recebido na variavel
            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = arrayRecebido.sort(compare);
            return resultado.slice(0, quantidade)
        },
// Fim da Funcção para ordenar e definir quantidade do vetor -----------------------------------------------------------

// Função para somar os valores das vendas por funcionario *************************************************************

        SomarVendas(array, quantidade) {
            var arrayVendas = array;
            var resultado = [];
            arrayVendas.reduce(function (res, value) {
                if (!res[value.funcionario_id]) {
                    res[value.funcionario_id] = {
                        funcionario_id: value.funcionario_id,
                        valor_venda: 0,
                        nome: value.nome,
                        imagem: value.imagem,
                        created_at: value.created_at

                    };
                    resultado.push(res[value.funcionario_id])
                }
                res[value.funcionario_id].valor_venda += value.valor_venda;
                return res;
            }, {});
            return this.OrdenarVetor(quantidade, resultado)

        },

// Fim da Função para somar os valores das vendas por funcionario ------------------------------------------------------

// filtar venda por dia semana mes ou ano ******************************************************************************
        VendasFiltro(situacao, array, quantidade, atual) {
            let data = new Date();
            let dia = '';
            let respostaSituacao = situacao;
            if (respostaSituacao == 1) {
                dia = data.getDate(); // retorna o dia
            } else if (respostaSituacao == 2) {
                dia = data.getDay(); // retorna o dia da semana
            } else {
                dia = data.getMonth() + 1; // retorna o mês
            }
            var arrayRecebido = array;
            var resultado = [];
            var resultadoFinal = [];
            arrayRecebido.reduce(function (res, value) {
                if (!res[value.funcionario_id]) {
                    res[value.funcionario_id] = {
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.funcionario.nome,
                        imagem: value.funcionario.imagem,
                        created_at: value.created_at
                    };
                    resultado.push(res[value.funcionario_id])
                }
                if (respostaSituacao == 1) {
                    res[value.funcionario_id].created_at = new Date(value.created_at).getDate();
                } else if (respostaSituacao == 2) {
                    res[value.funcionario_id].created_at = new Date(value.created_at).getDay();
                } else {
                    res[value.funcionario_id].created_at = new Date(value.created_at).getMonth() + 1;
                }
                if (res[value.funcionario_id].created_at == dia) {
                    res[value.funcionario_id] = {
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.funcionario.nome,
                        imagem: value.funcionario.imagem,
                        created_at: value.created_at
                    };
                    resultadoFinal.push(res[value.funcionario_id])
                }
                return res;
            }, {});
            if (resultadoFinal.length) {
                if (atual == 1) {
                    return resultadoFinal;
                } else {
                    return this.SomarVendas(resultadoFinal, quantidade)
                }

            }

            // return this.SomarVendas(resultadoFinal, quantidade)
        },
// Fim filtar venda por dia semana mes ou ano --------------------------------------------------------------------------

// Função equipe com mais vendas ***************************************************************************************

// Fim da Função equipe com mais vendas --------------------------------------------------------------------------------

// Função aniversariante do Mês ****************************************************************************************
        AniversarianteDoMes() {
            var array = this.funcionarios;
            var result = [];
            var result1 = [];
            var data = new Date().getMonth() + 1;
            array.reduce(function (res, value) {
                if (!res[value.id]) {
                    res[value.id] = {
                        id: value.id,
                        nome: value.nome,
                        data_nascimento: value.data_nascimento,
                        created_at: value.created_at
                    };
                    result.push(res[value.id])
                }
                res[value.id].data_nascimento = new Date(value.data_nascimento).getMonth() + 1;
                if (res[value.id].data_nascimento == data) {
                    res[value.id] = {
                        id: value.id,
                        nome: value.nome,
                        data_nascimento: value.data_nascimento,
                    };
                    result1.push(res[value.id])
                }
                // res[value.funcionario_id].valor_venda += value.valor_venda;
                return res;
            }, {});
            return result1
        },
// Fim da função aniversariante do Mês ---------------------------------------------------------------------------------

// função equipe Camarote **********************************************************************************************
        EquipeCamarote(quantidade) {
            var ArrayvendasDia = this.vendas;
            var result = [];
            ArrayvendasDia.reduce(function (res, value) {
                if (!res[value.equipe_id]) {
                    res[value.equipe_id] = {equipe_id: value.equipe_id, valor_venda: 0, created_at: value.created_at};
                    result.push(res[value.equipe_id])
                }
                res[value.equipe_id].valor_venda += value.valor_venda;
                return res;
            }, {});
            return result
        },

// Fim da Função equipe camarote ---------------------------------------------------------------------------------------
        ConvertendoNome(array) {
            var arrayFuncionario = this.funcionarios;
            return arrayFuncionario
        }
    },// fim methods
// fim dos metodos -----------------------------------------------------------------------------------------------------
    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
        this.CarregarApiFuncionarios();
    }
}
</script>
<style>
.xp-social-profile-avatar img {
    border: 5px solid #fff;
    margin-top: -10px;
}

.text-black {
    color: #555555 !important;
}

.card-header:first-child {
    border-radius: calc(.25rem - 1px) calc(.25rem - 1px) 0 0;
}
.card-header {
    border-bottom: 1px solid rgba(85, 85, 85, 0.05);
}
.bg-white {
    background-color: #ffffff !important;
}
.cardEquipe {
    border: none;
    box-shadow: 0 0 30px 0 rgba(200, 200, 200, 0.2);
    background-color: #1a202c;
}
.m-b-30 {
    margin-bottom: 30px;
}
.corDaImagem{
    background-color: #ffd400;
}
</style>
