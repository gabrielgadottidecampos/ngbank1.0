<template>
    <section class="team-section py-5">
        <div class="containerEquipe">
            <div v-for="(t, key) in ordenar()" :key="key">
                {{incrementIndex(key)}}
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6" v-if="keys == 1">
                        <div v-if="key==0">
                            <div class="cardMelhoresDaSemana border-0 shadow-lg pt-5 my-5 position-relative">
                                <div class="card-body p-4">
                                    <div class="member-profile position-absolute w-100 text-center">
                                        <img class="rounded-circle mx-auto d-inline-block shadow-sm"
                                             src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="">
                                        <h2 class="textoPreto">nome</h2>
                                    </div>
                                    <div class="card-text pt-1">
                                        <br>
                                        <hr>
                                        <div><h3 class="textoPreto"><img src="/storage/imagens/icons/money.png"
                                                                         class="tamanhoIcone"> R$ venenatis nunc.</h3>
                                        </div>
                                    </div>
                                </div><!--//card-body-->
                                <div class="card-footer theme-bg-primary border-0 text-center">
                                    <ul class="social-list list-inline mb-0 mx-auto">
                                        <li class="list-inline-item"><img src="/storage/imagens/icons/primeiroLugar.png"
                                                                          class="tamanhoIcone"></li>
                                    </ul><!--//social-list-->
                                </div><!--//card-footer-->
                            </div>
                        </div><!--//card-->
                    </div><!--//col-->
                    <div class="col-12 col-md-6" v-if="keys < 1">
                        <div v-if="key==1">
                            <div class="cardMelhoresDaSemana border-0 shadow-lg pt-5 my-5 position-relative">
                                <div class="card-body p-4">
                                    <div class="member-profile position-absolute w-100 text-center">
                                        <img class="rounded-circle mx-auto d-inline-block shadow-sm"
                                             src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="">
                                        <h2 class="textoPreto">nome</h2>
                                    </div>
                                    <div class="card-text pt-1">

                                        <br>
                                        <hr>
                                        <div><h3 class="textoPreto"><img src="/storage/imagens/icons/money.png"
                                                                         class="tamanhoIcone"> R$ venenatis nunc.</h3>
                                        </div>
                                    </div>
                                </div><!--//card-body-->
                                <div class="card-footer theme-bg-primary border-0 text-center">
                                    <ul class="social-list list-inline mb-0 mx-auto">
                                        <li class="list-inline-item"><img src="/storage/imagens/icons/segundoLugar.png"
                                                                          class="tamanhoIcone"></li>
                                    </ul><!--//social-list-->
                                </div><!--//card-footer-->
                            </div>
                        </div><!--//card-->
                    </div><!--//col-->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div v-if="key==2">
                            <div class="cardMelhoresDaSemana border-0 shadow-lg pt-5 my-5 position-relative">
                                <div class="card-body p-4">
                                    <div class="member-profile position-absolute w-100 text-center">
                                        <img class="rounded-circle mx-auto d-inline-block shadow-sm"
                                             src="https://bootdey.com/img/Content/avatar/avatar8.png" alt="">
                                        <h2 class="textoPreto">nome</h2>
                                    </div>
                                    <div class="card-text pt-1">
                                        <br>
                                        <hr>
                                        <div><h3 class="textoPreto"><img src="/storage/imagens/icons/money.png"
                                                                         class="tamanhoIcone"> R$ venenatis nunc.</h3>
                                        </div>
                                    </div>
                                </div><!--//card-body-->
                                <div class="card-footer theme-bg-primary border-0 text-center">
                                    <ul class="social-list list-inline mb-0 mx-auto">
                                        <li class="list-inline-item"><img src="/storage/imagens/icons/terceiroLugar.png"
                                                                          class="tamanhoIcone"></li>
                                    </ul><!--//social-list-->
                                </div><!--//card-footer-->
                            </div>
                        </div><!--//card-->
                    </div><!--//col-->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div v-if="key==3">
                            <div class="cardMelhoresDaSemana border-0 shadow-lg pt-5 my-5 position-relative">
                                <div class="card-body p-4">
                                    <div class="member-profile position-absolute w-100 text-center">
                                        <img class="rounded-circle mx-auto d-inline-block shadow-sm"
                                             src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="">
                                        <h2 class="textoPreto">nome</h2>
                                    </div>
                                    <div class="card-text pt-1">
                                        <br>
                                        <hr>
                                        <div><h3 class="textoPreto"><img src="/storage/imagens/icons/money.png"
                                                                         class="tamanhoIcone"> R$ venenatis nunc.</h3>
                                        </div>
                                    </div>
                                </div><!--//card-body-->
                                <div class="card-footer theme-bg-primary border-0 text-center">
                                    <ul class="social-list list-inline mb-0 mx-auto">
                                        <li class="list-inline-item"><img src="/storage/imagens/icons/medalha.png"
                                                                          class="tamanhoIcone"></li>
                                    </ul><!--//social-list-->
                                </div><!--//card-footer-->
                            </div>
                        </div><!--//card-->
                    </div><!--//col-->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div v-if="key==4">
                            <div class="cardMelhoresDaSemana border-0 shadow-lg pt-5 my-5 position-relative">
                                <div class="card-body p-4">
                                    <div class="member-profile position-absolute w-100 text-center">
                                        <img class="rounded-circle mx-auto d-inline-block shadow-sm"
                                             src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="">
                                        <h2 class="textoPreto">nome</h2>
                                    </div>
                                    <div class="card-text pt-1">
                                        <br>
                                        <hr>
                                        <div><h3 class="textoPreto"><img src="/storage/imagens/icons/money.png"
                                                                         class="tamanhoIcone"> R$ venenatis nunc.</h3>
                                        </div>
                                    </div>
                                </div><!--//card-body-->
                                <div class="card-footer theme-bg-primary border-0 text-center">
                                    <ul class="social-list list-inline mb-0 mx-auto">
                                        <li class="list-inline-item"><img src="/storage/imagens/icons/medalha.png"
                                                                          class="tamanhoIcone"></li>
                                    </ul><!--//social-list-->
                                </div><!--//card-footer-->
                            </div>
                        </div><!--//card-->
                    </div><!--//col-->
                </div><!--//row-->
            </div>
        </div>

    </section>
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
            keys: 0
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
                    if (value.dia > soma) {
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
        incrementIndex(key) {
            if(key == 0){
                this.keys = 1
            }else if(key == 1){
                this.keys = 2
            }else if(key == 2){
                this.keys = 3
            }else{
                this.keys = 4
            }
        },
    },
    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
    }
}
</script>
<style>
.pt-5 {
    padding-top: 3rem !important;
}

.my-5 {
    margin-top: 3rem !important;
    margin-bottom: 3rem !important;
}

.border-0 {
    border: 0 !important;
}

.position-relative {
    position: relative !important;
}

.shadow-lg {
    box-shadow: 0 1rem 3rem rgb(0 0 0 / 18%) !important;
}

.cardMelhoresDaSemana {
    position: relative;
    display: -webkit-flex;
    display: flex;
    -webkit-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: rgba(255, 255, 255, 0.78);
    background-clip: border-box;
    border: 1px solid rgba(0, 0, 0, 0.125);
    border-radius: .25rem;
}

.member-profile {
    top: -120px;
    left: 0;
}

.text-center {
    text-align: center !important;
}

.w-100 {
    width: 100% !important;
}

.position-absolute {
    position: absolute !important;
}

.member-profile img {
    width: 200px;
    height: 200px;
}

.rounded-circle {
    border-radius: 50% !important;
}

.mx-auto {
    margin-right: auto !important;
    margin-left: auto !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%) !important;
}

.tamanhoIcone {
    height: 70px;
    width: 70px;
}

.textoPreto {
    font-weight: bold;
    color: black;

}

.containerEquipe {
    max-width: 1500px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 30px;
}
</style>
