<template>
    <div class="container py-7">
        <h1 class="text-uppercase text-letter-spacing-xs my-0 text-white font-weight-bold text-center mb-2 mt-2">
            Melhores Do Mês <i class="ion-ios-body pl-1 text-primary op-8 z-index-1"></i>
        </h1>
        <hr class="hr-primary w-15 hr-xl ml-0 mb-5">
        <div v-for="(n,key) in ordenar()" :key="key">
        <div class="row mb-5MelhoresDoDia" v-if="key==0">
            <div class="col-md-6 order-md-2">
                <img v-bind:src="/storage/+n.imagem" alt="Primeiro Lugar" class="img-fluidTamanho border-white border-w-5 w-50 w-md-80 w-lg-60 rounded-circle">

            </div>
            <div class="col-md-6 flex-valign text-md-right">
                <h3 class="text-uppercase text-letter-spacing-xs mt-0 mb-1 text-white font-weight-bold">
                    <span><strong class="corPrimeiroColocado">1º &ensp;</strong> </span>
                   {{n.nome}}
                </h3>
                <hr class="hr-primary w-70 ml-0 ml-md-auto mr-md-0 mb-3">
                <h4><strong>Valor Vendido</strong></h4>
                <span><img src="https://cdn-icons-png.flaticon.com/512/2916/2916103.png" height="50" width="50"> <strong class=" text-white">R$ {{n.valor_venda}}</strong> </span>

            </div>
        </div>
        <div class="row mb-5MelhoresDoDia" v-if="key==1">
            <div class="col-md-6 text-md-right">
                <img v-bind:src="/storage/+n.imagem" alt="Segundo Lugar" class="img-fluidTamanho border-white border-w-5 w-50 w-md-80 w-lg-60 rounded-circle">
            </div>
            <div class="col-md-6 flex-valign">
                <h3 class="text-uppercase text-letter-spacing-xs mt-0 mb-1 text-white font-weight-bold">
                    <span><strong class="corSegundoColocado">2º
                        &ensp;</strong></span>
                    {{n.nome}}
                </h3>
                <hr class="hr-primary w-70 ml-0 mb-3">
                <h4><strong>Valor Vendido</strong></h4>
                <span><img src="https://cdn-icons-png.flaticon.com/512/2916/2916103.png" height="50" width="50"> <strong class=" text-white">R$ {{n.valor_venda}}</strong> </span>
            </div>
        </div>
        <div class="row mb-5MelhoresDoDia" v-if="key==2">
            <div class="col-md-6 order-md-2">
                <img v-bind:src="/storage/+n.imagem" alt="Terceiro Lugar" class="img-fluidTamanho border-white border-w-5 w-50 w-md-80 w-lg-60 rounded-circle">
            </div>
            <div class="col-md-6 flex-valign text-md-right">
                <h3 class="text-uppercase text-letter-spacing-xs mt-0 mb-1 text-white font-weight-bold">
                    <span><strong class="corTerceiroColocado">3º &ensp;</strong> </span>
                    {{n.nome}}
                </h3>
                <hr class="hr-primary w-70 ml-0 ml-md-auto mr-md-0 mb-3">
                <h4><strong>Valor Vendido</strong></h4>
                <span><img src="https://cdn-icons-png.flaticon.com/512/2916/2916103.png" height="50" width="50"> <strong class=" text-white"> R$ {{n.valor_venda}}</strong> </span>
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
            vendas: []
        }
    },
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
        AdicionarData(){
            var ArrayvendasDia = this.vendas;
            var result = [];
            ArrayvendasDia.reduce(function (res, value) {
                if (!res[value.id]) {
                    res[value.id] = {
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.funcionario.nome,
                        imagem: value.funcionario.imagem,
                        Mescreated_at: new Date(value.created_at).getMonth() + 1
                    };
                    result.push(res[value.id])
                }
                return res;
            }, {});
            return result
        },
        somaMes(){
            var ArrayvendasDia = this.AdicionarData();
            var result = [];
            ArrayvendasDia.reduce(function (res, value) {
                if (!res[value.funcionario_id]) {
                    res[value.funcionario_id] = {
                        funcionario_id: value.funcionario_id,
                        valor_venda: 0,
                        nome: value.nome,
                        imagem: value.imagem,
                        created_at: value.created_at
                    };
                    result.push(res[value.funcionario_id])
                }
                res[value.funcionario_id].valor_venda += value.valor_venda;
                return res;
            }, {});
            return result
        },
        ordenar() {
            var array = this.somaMes();
            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = array.sort(compare);
            return resultado.slice(0, 3)

        }
    },

    mounted() {
        this.carregarListaVenda();
    }
}
</script>
<style>

.border-5, .border-w-5 {
    border-width: 5px !important;
}
.border-white {
    border: 1px solid transparent;
    border-color: #fff !important;
}
hr.hr-primary {
    border-top-color: #CC164D!important;
}
em {
    font-style: italic;
}
.font-weight-normal {
    font-weight: 400 !important;
}
.mb-5MelhoresDoDia {
    margin-bottom: 1rem !important;
}
.corPrimeiroColocado{
    color: #ffd700;
}
.corSegundoColocado{
    color: #9f9f9f;
}
.corTerceiroColocado{
    color: #9c5221;
}
.img-fluidTamanho {
    max-width: 250px;
    height: 250px;
}
</style>
