<template>
    <div class="center">
        {{vendas}}
        <div class="cardFuncionarioSemana" v-for="(t, key) in  VendasFiltro(vendas, 3)" :key="key">
            <div class="additional" >
                <div class="user-card " >
                    <img v-bind:src="/storage/+t.imagem" class="img-fluid d-block mx-auto rounded-circle img-thumbnail mb-4">
                </div>
                <div class="more-info">
                    <h3>{{t.nome}}</h3>
                    <div class="stats">
                        <div>
                            <div class="title">Colocação</div>
                            <i class="fa fa-trophy"></i>
                            <div class="value">{{ incrementIndex(key)}}</div>
                        </div>
                        <div>
                            <div class="title">Valor</div>
                            <div class="value infinity mt-2">{{t.valor_venda}}</div>
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


        // filtar venda por dia semana mes ou ano ******************************************************************************
        VendasFiltro(array, quantidade) {
            let data = new Date();
            let dia = data.getDate();

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

                    res[value.funcionario_id].created_at = new Date(value.created_at).getDate();

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

            return this.SomarVendas(resultadoFinal, quantidade)
           // return resultadoFinal

        },

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
// fim trazer as informações da api de venda ---------------------------------------------------------------------------

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

        incrementIndex(key) {
            if(key == 0){
                this.activeColor = '#ffd700';
                return key + 1;
            }else if(key == 1){
                this.activeColor = '#c0c0c0';
                return key + 1;
            }else if(key == 2){
                this.activeColor = '#9c5221';
                return key + 1;
            }else{
                this.activeColor = '#ffffff';
                return key + 1;
            }
        },
    },
    mounted() {
        this.CarregarApiVendas(); // irá carregar o método

    }

}
</script>
<style>

.center {
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
}

.cardFuncionarioSemana {
    width: 450px;
    height: 200px;
    background-color: #fff;
    background: linear-gradient(#f8f8f8, #fff);
    box-shadow: 0 8px 16px -8px rgba(0,0,0,0.4);
    border-radius: 6px;
    overflow: hidden;
    position: relative;
    margin: 1.5rem;
}

.cardFuncionarioSemana h1 {
    text-align: center;
}

.cardFuncionarioSemana .additional {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(#cb8400, #ffffff);
    transition: width 0.4s;
    overflow: hidden;
    z-index: 2;
}

.cardFuncionarioSemana.green .additional {
    background: linear-gradient(#92bCa6, #A2CCB6);

}
.cardFuncionarioSemana .additional .user-card {
    width: 150px;
    height: 100%;
    position: relative;
    float: left;
}

.cardFuncionarioSemana .additional .user-card::after {
    content: "";
    display: block;
    position: absolute;
    top: 10%;
    right: -2px;
    height: 80%;
    border-left: 2px solid rgba(0,0,0,0.025);
}

.cardFuncionarioSemana .additional .user-card .level,
.cardFuncionarioSemana .additional .user-card .points {
    top: 15%;
    color: #fff;
    text-transform: uppercase;
    font-size: 0.75em;
    font-weight: bold;
    background: rgba(0,0,0,0.15);
    padding: 0.125rem 0.75rem;
    border-radius: 100px;
    white-space: nowrap;
}

.cardFuncionarioSemana .additional .user-card .points {
    top: 85%;
}

.cardFuncionarioSemana .additional .user-card svg {
    top: 50%;
}

.cardFuncionarioSemana .additional .more-info {
    width: 300px;
    float: left;
    position: absolute;
    left: 150px;
    height: 100%;
}

.cardFuncionarioSemana .additional .more-info h3 {
    color: #fff;
    margin-bottom: 0;
}

.cardFuncionarioSemana.green .additional .more-info h1 {
    color: #224C36;
}

.cardFuncionarioSemana .additional .coords {
    margin: 0 1rem;
    color: #fff;
    font-size: 1rem;
}

.cardFuncionarioSemana.green .additional .coords {
    color: #325C46;
}

.cardFuncionarioSemana .additional .coords span + span {
    float: right;
}

.cardFuncionarioSemana .additional .stats {
    font-size: 2rem;
    display: flex;
    position: absolute;
    bottom: 1rem;
    left: 1rem;
    right: 1rem;
    top: auto;
    color: #fff;
}

.cardFuncionarioSemana.green .additional .stats {
    color: #325C46;
}

.cardFuncionarioSemana .additional .stats > div {
    flex: 1;
    text-align: center;
}

.cardFuncionarioSemana .additional .stats i {
    display: block;
}

.cardFuncionarioSemana .additional .stats div.title {
    font-size: 0.75rem;
    font-weight: bold;
    text-transform: uppercase;
}

.cardFuncionarioSemana .additional .stats div.value {
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 1.5rem;
}

.cardFuncionarioSemana .additional .stats div.value.infinity {
    font-size: 2.5rem;
}
.img-thumbnail{
    width:110px;
    height:110px;
    margin-top: 50%;
}


</style>

