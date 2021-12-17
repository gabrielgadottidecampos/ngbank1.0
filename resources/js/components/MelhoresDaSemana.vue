<template>
     <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title title-left text-center text-lg-left mt-5 ">
                    <h2 class="top-sep text-center text-white sombratexto">Melhores Da Semana</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <div class="col-md-6 col-lg-4 mb-30">
                <div class="team-item" v-for="a in  ordenar()">
                    <div class="mb-30 position-relative d-flex align-items-center">
                            <span class="socials d-inline-block">
                                <a href="#" class="zmdi zmdi-facebook"></a>
                            </span>
                        <span class="img-holder d-inline-block">
                                <img v-bind:src="/storage/+a.imagem" alt="Team" height="270" width="270">
                            </span>
                    </div>
                    <div class="team-content">
                        <h3 class="mb-2 mt-2 text-white sombratexto">{{a.nome}}</h3>
                        <p class="text-uppercase mb-0">{{a.valor_venda}}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-30">
                <div class="team-item">
                    <div class="mb-30 position-relative d-flex align-items-center">
                            <span class="socials d-inline-block">
                                <a href="#" class="zmdi zmdi-facebook"></a>
                                <a href="#" class="zmdi zmdi-twitter"></a>
                                <a href="#" class="zmdi zmdi-google"></a>
                                <a href="#" class="zmdi zmdi-instagram"></a>
                            </span>
                        <span class="img-holder d-inline-block">
                                <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Team">
                            </span>
                    </div>
                    <div class="team-content">
                        <h5 class="mb-2">Serena Whatson</h5>
                        <p class="text-uppercase mb-0">UI/UX Designer</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-30">
                <div class="team-item">
                    <div class="mb-30 position-relative d-flex align-items-center">
                            <span class="socials d-inline-block">
                                <a href="#" class="zmdi zmdi-facebook"></a>
                                <a href="#" class="zmdi zmdi-twitter"></a>
                                <a href="#" class="zmdi zmdi-google"></a>
                                <a href="#" class="zmdi zmdi-instagram"></a>
                            </span>
                        <span class="img-holder d-inline-block">
                                <img src="https://bootdey.com/img/Content/avatar/avatar8.png" alt="Team">
                            </span>
                    </div>
                    <div class="team-content">
                        <h5 class="mb-2">Dave Serene</h5>
                        <p class="text-uppercase mb-0">CEO</p>
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
        }
    },
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
                        Mes: new Date(value.created_at).getUTCMonth() + 1,
                        dia: new Date(value.created_at).getUTCDate(),
                        created_at: value.created_at
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
                    if(value.dia > soma ) {
                        if (!res[value.funcionario_id]) {
                            res[value.funcionario_id] = {
                                funcionario_id: value.funcionario_id,
                                valor_venda: 0,
                                nome: value.nome,
                                imagem: value.imagem,
                                dia: value.dia
                            };
                            result.push(res[value.funcionario_id])
                        }
                        res[value.funcionario_id].valor_venda += value.valor_venda;
                    }

                }
                return res;
            }, {});
            return result;
        },
        ordenar() {
            var array = this.melhoresDaSemana();

            function compare(a, b) {
                if (a.created_at < b.created_at)
                    return 1;
                if (a.created_at > b.created_at)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            return resultado.slice(0, 3)

        },
    },
    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
    }
}
</script>
<style>

/* ===== ABOUT PAGE ===== */
.team-item {
    padding: 35px;
    padding-right: 0;
    position: relative;
    z-index: 0;
}

.team-item:after, .team-item:before {
    content: "";
    position: absolute;
    -webkit-box-shadow: 0 5px 30px 0 rgba(39, 39, 39, 0.15);
    box-shadow: 0 5px 30px 0 rgba(39, 39, 39, 0.15);
    border-radius: 10px;
    z-index: -1;
}

.team-item:before {
    height: 100%;
    background-color: #ffffff;
    left: 0;
    top: 0;
    right: 30px;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.team-item:hover:after {
    height: 100%;
}

.team-item .img-holder {
    -ms-flex-negative: 0;
    flex-shrink: 0;
    -webkit-box-shadow: 0 0 20px 0 rgba(51, 51, 51, 0.2);
    box-shadow: 0 0 20px 0 rgba(51, 51, 51, 0.2);
    border-radius: 10px;
    width: calc(100% - 70px);
    margin-left: 70px;
    overflow: hidden;
}

.team-item .img-holder img {
    border-radius: 10px;
    width: 100%;
    -webkit-transform: scale(1.1);
    transform: scale(1.1);
    -webkit-transition: all 0.6s ease;
    transition: all 0.6s ease;
}

.team-item:hover .img-holder img {
    -webkit-transform: scale(1);
    transform: scale(1);
}

.team-item .socials {
    position: absolute;
}

.team-item .socials a {
    display: block;
    margin-right: 0;
    margin-bottom: 15px;
    -webkit-box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.12);
    box-shadow: 0 3px 2px 0 rgba(0, 0, 0, 0.12);
}

.team-item .socials a:last-of-type {
    margin-bottom: 0;
}

.team-item .team-content {
    margin-right: 70px;
    text-align: center;
}

.team-item .team-content h5 {
    color: #101f41;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
}


.team-item:hover .team-content h5, .team-item:hover .team-content p {
    color: #fff;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}

.d-inline-block {
    display: inline-block!important;
}

.socials a {
    width: 35px;
    height: 35px;
    background-color: #6893e1;
    border-radius: 50%;
    -webkit-box-shadow: 0 3px 2px 0 #516cd9;
    box-shadow: 0 3px 2px 0 #516cd9;
    text-align: center;
    color: #fff;
    padding-top: 10px;
    font-size: 16px;
    margin-right: 10px;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
}
.primeiroLugarSemana{
    background-color: #ff0000;
}
.segundoLugarSemana{
    background-color: #ff0000;
}
.terceiroLugarSemana{
    background-color: #ff0000;
}
</style>
