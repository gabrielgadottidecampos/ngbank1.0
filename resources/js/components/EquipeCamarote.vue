<template>
    <div class="container">
       {{VendasFiltro(vendas)}}
        {{ funcionarioImagems }}
        {{ carregandoImagemFuncionario() }}

        {{ teste2 }}


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
            funcionarios: [],
            funcionarioImagems: [],
            imagemEquipe: '',
            teste: '',
            teste2: ''
        }
    },
// inicio dos metodos **************************************************************************************************
    methods: {
// trazer as informações da api de venda *******************************************************************************
        CarregarApiVendas() {
            axios.get(this.urlBaseVenda)
                .then(response => {
                    this.vendas = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
// fim trazer as informações da api de venda ---------------------------------------------------------------------------
        CarregarApiFuncionarios() {
            axios.get(this.urlBaseFuncionario)
                .then(response => {
                    this.funcionarios = response.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
// carregar informações funcionario ************************************************************************************
        VendasFiltro(array) {
            let data = new Date();
            let dia = data.getDate();
            var arrayRecebido = array;
            var resultado = [];
            var resultadoFinal = [];
            arrayRecebido.reduce(function (res, value) {
                if (!res[value.funcionario_id]) {
                    res[value.funcionario_id] = {
                        funcionario_id: value.funcionario_id,
                        equipe_id: value.equipe_id,
                        valor_venda: value.valor_venda,
                        imagem: value.funcionario.imagem,
                        created_at: value.created_at
                    };
                    resultado.push(res[value.funcionario_id])
                }

                res[value.funcionario_id].created_at = new Date(value.created_at).getDate();

                if (res[value.funcionario_id].created_at == dia) {
                    res[value.funcionario_id] = {
                        funcionario_id: value.funcionario_id,
                        equipe_id: value.equipe_id,
                        valor_venda: value.valor_venda,
                        imagem: value.funcionario.imagem,
                        created_at: value.created_at
                    };
                    resultadoFinal.push(res[value.funcionario_id])
                }
                return res;
            }, {});

            return this.EquipeCamarote(resultadoFinal)
            // return resultadoFinal

        },

        EquipeCamarote(quantidade) {
            var ArrayvendasDia = quantidade;
            var result = [];
            ArrayvendasDia.reduce(function (res, value) {
                if (!res[value.equipe_id]) {
                    res[value.equipe_id] = {equipe_id: value.equipe_id, valor_venda: 0, created_at: value.created_at};
                    result.push(res[value.equipe_id])
                }
                res[value.equipe_id].valor_venda += value.valor_venda;
                return res;
            }, {});
            return this.OrdenarVetor(result)
        },
        OrdenarVetor(array) { // quantidade: a quantidade que ira retornar, array: array que irá receber
            var arrayRecebido = array; // salva o array recebido na variavel
            function compare(a, b) {
                if (a.valor_venda < b.valor_venda)
                    return 1;
                if (a.valor_venda > b.valor_venda)
                    return -1;
                return 0;
            }

            var resultado = arrayRecebido.sort(compare);
            this.funcionarioImagems = resultado.slice(0, 1);
            return resultado.slice(0, 1);
        },
        carregandoImagemFuncionario() {
            var result = [];
            var imga = '';
            var a = ''
            this.funcionarioImagems.reduce(function (res, value) {
                if(value.equipe_id){
                    a = value.equipe_id
                    res[value.equipe_id] = {
                        equipe_id: value.equipe_id}
                }
            },{})
           // this.teste2 = a;
            this.funcionarios.reduce(function (res, value) {
                if (value.equipe_id) {
                    if (value.equipe_id ==  a) {
                        res[value.equipe_id] = {
                            equipe_id: value.equipe_id,
                            imagem: value.imagem,
                            imagemEquipe: value.equipe.imagem
                        };
                        imga = value.equipe.imagem,
                            result.push(res[value.equipe_id])
                    }
                }
                return res;
            }, {});
            this.teste = imga
            return result
        },
    },

    mounted() {
        this.CarregarApiVendas(); // irá carregar o método
        this.CarregarApiFuncionarios();
    }
}
</script>
