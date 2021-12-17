<template>
    <div class="container">
        <div class="row">
            <div class="col-xl-6 ">
                <div class="card designCardMelhoresDia">
                    <div class="card-body designCardMelhoresDia">
                        <h4 class="header-title pb-3 mt-0 text-center text-white sombratexto">Melhores Do Dia</h4>
                        <div v-for="(t, key) in  ordenar()" :key="key">
                            {{incrementIndex(key)}}
                        <div class="row well well-purple mini-profile-widget rounded shadow p-3 mb-5" v-bind:style="{ background: activeColor}">
                            <div class="col-md-6">
                                <div class="image-container mt-3 mb-2">
                                    <img v-bind:src="/storage/+t.imagem"
                                         class="avatar img-responsive" alt="avatar" height="130"
                                         width="130">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="details mt-2 text-white sombratexto">
                                    <h4>{{t.nome}}</h4>
                                    <hr>
                                    <div class="text-white sombratexto">Total Em Vendas</div>
                                    <h4>
                                    <span><img src="https://cdn-icons-png.flaticon.com/512/2916/2916103.png" height="60" width="60"> <strong class="text-white sombratexto"> R$ {{t.valor_venda}}</strong></span>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card designCardMelhoresDia">
                    <div class="card-body designCardMelhoresDia">
                        <h4 class="header-title pb-3 mt-0 text-center text-white sombratexto">Ultimas Vendas</h4>
                        <div class="table ">
                            <table class="table" v-for="v in  ordenarVendasDia()">
                                <tbody >
                                <tr>
                                    <td class="border-top-1">
                                        <div class="media"><img v-bind:src="/storage/+v.imagem" alt=""
                                                                class="thumb-md rounded-circle" height="130"
                                                                width="130">
                                            <div class="text-center text-white sombratexto">
                                                <h4><span class="text-darktext-white sombratexto">{{ v.nome }}</span></h4>
                                                <hr>
                                                <h4> <span><img src="https://cdn-icons-png.flaticon.com/512/2916/2916103.png" height="60" width="60"> <strong class="text-white sombratexto"> R$ {{ v.valor_venda }}</strong></span>
                                                </h4>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
            urlBaseVenda: 'http://127.0.0.1:8000/api/v1/venda',
            vendas: [],
            activeColor: 'red',
        }
    },
// inicio dos metodos **************************************************************************************************
    methods: {
        // trazer as informações da api de venda *******************************************************************************
        CarregarApiVendas() {
            axios.get(this.urlBaseVenda)
                .then(response => {
                    this.vendas = response.data.data
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
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.funcionario.nome,
                        imagem: value.funcionario.imagem,
                        Mescreated_at: new Date(value.created_at).getMonth() + 1,
                        Dia: new Date(value.created_at).getUTCDate(),
                        created_at: value.created_at
                    };
                    result.push(res[value.id])
                }
                return res;
            }, {});
            return result
        },
        filtrarMelhoresDoDia() {
            var data = new Date();
            var result = [];
            var arrayMelhoresDoDia = this.AdicionarData();
            arrayMelhoresDoDia.reduce(function (res, value) {
                if (value.Mescreated_at == data.getMonth() + 1 && value.Dia == data.getDate()) {
                    if (!res[value.funcionario_id]) {
                        res[value.funcionario_id] = {
                            funcionario_id: value.funcionario_id,
                            valor_venda: 0,
                            nome: value.nome,
                            imagem: value.imagem,
                        };
                        result.push(res[value.funcionario_id])
                    }

                    res[value.funcionario_id].valor_venda += value.valor_venda;
                }

                return res;
            }, {});
            return result
        },
        filtrarVendasDoDia() {
            var data = new Date();
            var result = [];
            var arrayMelhoresDoDia = this.AdicionarData();
            arrayMelhoresDoDia.reduce(function (res, value) {
                if (value.Mescreated_at == data.getMonth() + 1 && value.Dia == data.getDate()) {
                    res[value.id] = {
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.nome,
                        imagem: value.imagem,
                        created_at: value.created_at
                    };
                    result.push(res[value.id])
                }

                return res;
            }, {});
            return result
        },
        ordenar() {
            var array = this.filtrarMelhoresDoDia();

            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            return resultado.slice(0, 3)

        },
        ordenarVendasDia() {
            var array = this.filtrarVendasDoDia();

            function compare(a, b) {
                if (a.created_at < b.created_at)
                    return 1;
                if (a.created_at > b.created_at)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            return resultado.slice(0, 5)

        },
        incrementIndex(key) {
            if(key == 0){
                this.activeColor = '#ffd700';
            }else if(key == 1){
                this.activeColor = '#c0c0c0';
            }else if(key == 2){
                this.activeColor = '#9c5221';
            }else{
                this.activeColor = '#ffffff';
            }
        },

    },
    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
    }

}
</script>
<style>
.bordaPretaImagem {
    border: 1px solid #000000;
}
.sombratexto{
    text-shadow: black 0.1em 0.1em 0.2em
}

/* Component: Well */
.well {
    overflow: hidden;
    border-radius: 0;
    margin-bottom: 30px;
}

.well .well-heading .controls {
    position: absolute;
    top: 10px;
    right: 30px;
}

.well .well-body {
    margin-top: 20px;
    position: relative;
    z-index: 3;
}

.well .well-image {
    font-size: 90px;
    line-height: 90px;
    position: absolute;
    top: 20px;
    right: 30px;
    z-index: 1;
    color: rgba(0, 0, 0, 0.15);
    -webkit-transition: all 0.2s ease-in;
    -moz-transition: all 0.2s ease-in;
    -ms-transition: all 0.2s ease-in;
    -o-transition: all 0.2s ease-in;
    transition: all 0.2s ease-in;
}

.well:hover .well-image {
    font-size: 60px;
}


.well-purple {
    background-color: #8e44ad;
    color: white;}


.mini-profile-widget .image-container .avatar {
    width: 180px;
    height: 180px;
    display: block;
    margin: 0 auto;
    border-radius: 50%;
    background: white;
    padding: 4px;
    border: 1px solid #dddddd;
}

.btn-blue {
    background-color: #3498db;
    border-color: #3498db;
    color: white;
}

.btn-blue:hover,
.btn-blue:visited {
    background-color: #2980b9;
    color: white;
}

.btn-green {
    background-color: #2ecc71;
    border-color: #27ae60;
    color: white;
}

.btn-green:hover,
.btn-green:visited {
    background-color: #27ae60;
    color: white;
}

.btn-orange {
    background-color: #ff530d;
    border-color: #e82c0c;
    color: white;
}

.btn-orange:hover,
.btn-orange:visited {
    background-color: #e82c0c;
    color: white;
}

.btn-red {
    background-color: #ff1d23;
    border-color: #d40d12;
    color: white;
}

.btn-red:hover,
.btn-red:visited {
    background-color: #d40d12;
    color: white;
}

.btn-purple {
    background-color: #9b59b6;
    border-color: #8e44ad;
    color: white;
}

.btn-purple:hover,
.btn-purple:visited {
    background-color: #8e44ad;
    color: white;
}

.btn-pink {
    background-color: #fd32c0;
    border-color: #fe31ab;
    color: white;
}

.btn-pink:hover,
.btn-pink:visited {
    background-color: #fe31ab;
    color: white;
}
.designCardMelhoresDia{
    padding: 0.25rem;
    border-radius: 1.25rem;
    background-color: #ffffff57;
}
.tabelaTamanhoMelhoresdoDia{
    margin-bottom: 0.7rem
}
.displayflexMelhoresdodia{
    display: flex;
    align-items: center;
}
</style>

