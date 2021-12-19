<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card m-b-30">
                    <div class="card-header bg-white">
                        <h3 class="card-title mb-0 text-center text-white sombratexto">Equipe Camarote</h3>
                    </div>
                    <div class="card-body">
                        <div class="xp-social-profile">
                            <div class="xp-social-profile-img">
                                <div class="row">
                                    <div class="col px-1" v-for="a in listandoGanhadores()">
                                        <img v-bind:src="/storage/+a.imagem" class="rounded img-fluid" alt="img"
                                             width="200" height="200">
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
                                            <img v-bind:src="/storage/+imagemEquipe" alt="user-profile"
                                                 class="rounded-circle img-fluid" width="200" height="200">
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
                                            <h2 class="my-1 text-black">{{ nomeEquipe }}</h2>
                                        </div>
                                        <hr>
                                        <div>
                                            <img src="https://cdn-icons-png.flaticon.com/512/2916/2916103.png"
                                                 height="60px" width="60px">
                                            <h2 class="text-white sombratexto">R$ {{ valor[0] }}</h2>
                                        </div>
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
    // inicio Data *********************************************************************************************************
    data() {
        return {
            urlBaseVenda: 'http://127.0.0.1:8000/api/v1/venda',
            urlBaseFuncionario: 'http://127.0.0.1:8000/api/v1/funcionario',
            vendas: [],
            funcionarios: [],
            equipesVencedoras: [],
            salvagod: [],
            salvarOrdenar: [],
            imagemEquipe: '',
            valor: [],
            nomeEquipe: [],
        }
    },
    // fim Data *********************************************************************************************************

    methods: {
        // metodo listar vendas ****************************************************************************************
        carregarListaVenda() {
            let url = this.urlBaseVenda
            console.log(url)
            axios.get(url)
                .then(response => {
                    this.vendas = response.data.data;
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        // fim metodo listar vendas ------------------------------------------------------------------------------------
        carregarListaFuncionario() {
            let url = this.urlBaseFuncionario
            axios.get(url)
                .then(response => {
                    this.funcionarios = response.data.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        AdicionarData() {
            var ArrayvendasDia = this.vendas;
            var result = [];
            ArrayvendasDia.reduce(function (res, value) {
                if (!res[value.id]) {
                    res[value.id] = {
                        id: value.id,
                        equipe_id: value.equipe_id,
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.funcionario.nome,
                        Mes: new Date(value.created_at).getUTCMonth() + 1,
                        dia: new Date(value.created_at).getUTCDate(),
                    };
                    result.push(res[value.id])
                }
                return res;
            }, {});
            return result
        },
        melhoresDaSemana() {
            var dataAtual = new Date();
            var result = [];
            var diaAtual = dataAtual.getUTCDay();
            dataAtual.setDate(dataAtual.getDate() - diaAtual);
            var soma = dataAtual.getUTCDate();
            var arrayMelhoresDoDia = this.AdicionarData();
            arrayMelhoresDoDia.reduce(function (res, value) {
                if (value.Mes == dataAtual.getMonth() + 1) {
                    if (value.dia >= soma) {
                        if (!res[value.equipe_id]) {
                            res[value.equipe_id] = {
                                equipe_id: value.equipe_id,
                                valor_venda: 0,
                            };
                            result.push(res[value.equipe_id])
                        }
                        res[value.equipe_id].valor_venda += value.valor_venda;
                    }

                }
                return res;
            }, {});
            return result;
        },
        ordenar() {
            var array = this.melhoresDaSemana();

            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            this.salvarOrdenar = resultado.slice(0, 1);
            return resultado.slice(0, 1)

        },
        equipeGanhadora() {
            var resultado = this.ordenar();
            for (var i = 0; i < resultado.length; i++) {
                this.equipesVencedoras[i] = resultado[i].equipe_id
                this.valor[i] = resultado[i].valor_venda

            }
        },
        listandoGanhadores() {
            this.equipeGanhadora();
            var arrayEquipes = this.funcionarios;
            var teste = this.equipesVencedoras[0]
            var result = [];
            var imagemEquipe;
            var nomeEquipe;
            arrayEquipes.reduce(function (res, value) {
                if (teste == value.equipe_id) {
                    if (!res[value.id]) {
                        res[value.id] = {
                            nome: value.nome,
                            imagem: value.imagem,
                            equipe_id: value.equipe_id
                        }

                        result.push(res[value.id])
                    }
                    imagemEquipe = value.equipe.imagem;
                    nomeEquipe = value.equipe.nome
                }

                return res;
            }, {});
            this.imagemEquipe = imagemEquipe;
            this.nomeEquipe = nomeEquipe;
            return result;
        },

    },
    mounted() {
        this.carregarListaVenda();
        this.carregarListaFuncionario();
        this.imagemEquipe = '';
    }
}
</script>
<style>
/*  -----  Widget - Social Profile  -----  */
.xp-social-profile-avatar img {
    margin-top: -20px;
    border: 5px rgba(0, 0, 0, 0.3);
    box-shadow: rgba(0, 0, 0, 0.3) 0px 1px 20px
}

.xp-social-profile-avatar .xp-social-profile-live {
    position: absolute;
    bottom: 15px;
    margin: 0px -20px;
    width: 15px;
    height: 15px;
    border-radius: 50%;
    border: 2px solid #ffffff;
    background-color: #2bcd72;
}

.text-black {
    color: #555555 !important;
}

.mb-1, .my-1 {
    margin-bottom: .25rem !important;
}

.mt-1, .my-1 {
    margin-top: .25rem !important;
}

.h5, h5 {
    font-size: 1.25rem;
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

.card {
    border: none;
    box-shadow: 0 0 30px 0 rgba(200, 200, 200, 0.2);
}

.m-b-30 {
    margin-bottom: 30px;
}
</style>

