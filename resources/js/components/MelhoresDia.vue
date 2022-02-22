<template>
    <div class="container bootstrap snippets bootdey">
        <section id="testimonials" class="content-first">
            <div class="container bootstrap snippets bootdey">
                <h1 class="text-center">MELHORES DO DIA</h1>
{{salvarResuldato() }}
                <hr>
                <div class="row" v-if="contador >=1">
                    <!-- TESTIMONIAL 1 - START -->
                    <div class="col-sm-6">
                        <div class="media">
                            <a class="pull-left" href="#"><img class="media-object img-circle" v-bind:src="/storage/+imagem[0]"  alt=""></a>
                            <div class="media-body">
                                <h3 class="media-heading">{{nome[0]}}</h3>
                                <hr class="hrMelhoresDoDia">
                                <p><img src="storage/imagens/icons/money.png" width="45" height="45"> R$ {{ valor[0] }} </p>
                                <hr class="hrMelhoresDoDia">
                                <img class="tamanhoIconeMelhoresDoDia" src="storage/imagens/icons/1.png">

                            </div>
                        </div>
                    </div>
                    <!-- TESTIMONIAL 1 - END -->
                    <div class="col-sm-6" v-if="contador>=2">
                        <div class="media">
                            <a class="pull-left" href="#"><img class="media-object img-circle" v-bind:src="/storage/+imagem[1]" alt=""></a>
                            <div class="media-body">
                                <h3 class="media-heading">{{nome[1]}}</h3>
                                <hr class="hrMelhoresDoDia">
                                <p><img src="storage/imagens/icons/money.png" width="45" height="45"> R${{valor[1]}}</p>
                                <hr class="hrMelhoresDoDia">
                                <img class="tamanhoIconeMelhoresDoDia" src="storage/imagens/icons/2.png">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex justify-content-center mt-4" v-if="contador>=3">
                    <div class="col-sm-6 ">
                        <div class="media ">
                            <a class="pull-left" href="#"><img class="media-object img-circle"  v-bind:src="/storage/+imagem[2]" alt=""></a>
                            <div class="media-body">
                                <h3 class="media-heading">{{nome[2]}}</h3>
                                <hr class="hrMelhoresDoDia">
                                <p><img src="storage/imagens/icons/money.png" width="45" height="45"> R${{valor[2]}}</p>
                                <hr class="hrMelhoresDoDia">
                                <img class="tamanhoIconeMelhoresDoDia" src="storage/imagens/icons/3.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
export default {
    data() {
        return {
            contador:0,
            urlBaseVenda: 'http://127.0.0.1:8000/api/v1/venda',
            vendas: [],
            nome: [],
            imagem: [],
            valor: [],
        }
    },
// inicio dos metodos **************************************************************************************************
    methods: {
        // trazer as informações da api de venda ***********************************************************************
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
                        Dia: new Date(value.created_at).getUTCDate(),
                        Mes: new Date(value.created_at).getMonth() + 1,

                        // created_at: value.created_at
                    };
                    result.push(res[value.id])
                }
                return res;
            }, {});
            return result
        },
        // filtrar vendas do dia ***************************************************************************************
        VendasDia() {
            var data = new Date();
            var result = [];
            var arrayMelhoresDoDia = this.AdicionarData();
            arrayMelhoresDoDia.reduce(function (res, value) {
                if (value.Mes == data.getMonth() + 1 && value.Dia == data.getDate()) {
                    if (!res[value.funcionario_id]) {
                        res[value.funcionario_id] = {
                            funcionario_id: value.funcionario_id,
                            valor_venda: 0,
                            nome: value.nome,
                            imagem: value.imagem,
                            dia: value.Dia,
                            mes: value.Mes,

                        };
                        result.push(res[value.funcionario_id])
                    }

                    res[value.funcionario_id].valor_venda += value.valor_venda;
                }

                return res;
            }, {});
            return result
        },
        // somar vendas do dia *****************************************************************************************
        ordenar() {
            var array = this.VendasDia();

            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            this.contador = resultado.length
            return resultado.slice(0, 3)

        },
        salvarResuldato() {
            var arrayNomes = this.ordenar();
            if(this.contador >0){
                for (var i = 0; i < 1; i++) {
                    if(this.contador<=1){
                        this.nome[0] = arrayNomes[0].nome
                        this.valor[0] = arrayNomes[0].valor_venda
                        this.imagem[0] = arrayNomes[0].imagem
                    }
                    else if(this.contador<=2){
                        for (var item in arrayNomes) {
                            this.nome[0] = arrayNomes[0].nome
                            this.nome[1] = arrayNomes[1].nome
                            this.valor[0] = arrayNomes[0].valor_venda
                            this.valor[1] = arrayNomes[1].valor_venda
                            this.imagem[0] = arrayNomes[0].imagem
                            this.imagem[1] = arrayNomes[1].imagem
                        }
                    }
                    else{
                        for (var item in arrayNomes) {
                            this.nome[0] = arrayNomes[0].nome
                            this.nome[1] = arrayNomes[1].nome
                            this.nome[2] = arrayNomes[2].nome
                            this.valor[0] = arrayNomes[0].valor_venda
                            this.valor[1] = arrayNomes[1].valor_venda
                            this.valor[2] = arrayNomes[2].valor_venda
                            this.imagem[0] = arrayNomes[0].imagem
                            this.imagem[1] = arrayNomes[1].imagem
                            this.imagem[2] = arrayNomes[2].imagem
                        }
                    }


                }
            }


        }

    },

    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
        //this.salvarResuldato();
    }
}
</script>
<style>

.content-first {
    padding: 5px 0;
    color: #FFFFFF;
    border-top: 8px inset #333;
    border-top: 8px solid rgba(0, 0, 0, 0.1);
    box-shadow: 0px 1px 0px rgba(255, 255, 255, 0.2);
}

.media, .media-body {
    overflow: hidden;
    zoom: 1;
}

#testimonials .media a.pull-left img {
    max-width: 150px;
}

#testimonials .media .media-body {
    background-color: rgba(0, 0, 0, 0.1);
    padding: 15px 20px;
    border-radius: 12px;
}

#testimonials .media .media-body h3 {
    margin: 0;
    font-weight: bold;
    font-size: 26px;
}

#testimonials .media .media-body span {
    margin: 5px 0 15px;
    display: block;
    font-weight: bold;
    font-style: italic;
    font-size: 14px;
    color: #333;
}

#testimonials .media .media-body p {
    margin: 0;
    padding: 5px 0 0;
    border-top: 1px dashed rgba(0, 0, 0, 0.2);
    text-align: left;
    line-height: 25px;
    font-size: 20px;
}

.tamanhoIconeMelhoresDoDia {
    weight: 50px;
    height: 50px;
    display: block;
    margin-left: auto;
    margin-right: auto
}

.hrMelhoresDoDia {
    border-top: 1px solid white;
}
</style>

