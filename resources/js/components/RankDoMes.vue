<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <div class="gridrankequipecamarote grid-body">
                        <div class="row gridrankequipecamarote">
                            <!-- BEGIN RESULT -->
                            <div class="col">
                                <h2 class="mt-2 mb-2"><img src="storage/imagens/icons/ranking.png" width="65" height="65"> Rank do Mês</h2>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <tbody><tr v-for="(t, key) in ordenar()" :key="key">
                                            <td class="number text-center testerankequipecamarote">{{key+1}}</td>
                                            <td class="imgrankequipe"><img v-bind:src="/storage/+t.imagem" alt=""  width="50" height="50"></td>
                                            <td class="product testerankequipecamarote">{{t.nome}}</td>
                                            <td class="price text-right">R${{t.valor_venda}}</td>
                                        </tr>
                                        </tbody></table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style>
.gridrankequipecamarote {
    position: relative;
    background: #fff;
    color: #666666;
}
.imgrankequipe {
    width: 45px;
    height: 45px;
}
.price {
    font-size: 1.5em;
    line-height: 45px;
}
.testerankequipecamarote{
    line-height: 50px;
    font-size: 1.5em;
    line-height: 45px;
}
</style>
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
        VendasMes() {
            var data = new Date();
            var result = [];
            var arrayMelhoresDoDia = this.AdicionarData();
            arrayMelhoresDoDia.reduce(function (res, value) {
                if (value.Mes == data.getMonth() + 1) {
                    if (!res[value.funcionario_id]) {
                        res[value.funcionario_id] = {
                            funcionario_id: value.funcionario_id,
                            valor_venda: 0,
                            nome: value.nome,
                            imagem: value.imagem,
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
            var array = this.VendasMes();

            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            this.contador = resultado.length
            return resultado.slice(0, 10)

        },

    },

    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
        //this.salvarResuldato();
    }
}
</script>
