<template>
    <div class="container">
       <ul v-for="t in filtrar()">
           <li>{{t.id}}</li>
           <li>{{t.nome}}</li>
           <li>{{t.valor_venda}}</li>
           <li> Dia {{t.Diacreated_at}}</li>
           <li> Semana {{t.Semanacreated_at}}</li>
           <li> Mes {{t.Mescreated_at}}</li>

       </ul>

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
            vendas: []
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

        // inicio metodo filtrar vendas por data ***********************************************************************
        filtrar() {
            var arrayVendas = this.vendas;
            var data = new Date();
            var result = [];
            var diaAtual = 4;
            arrayVendas.reduce(function (res, value) {
                if (!res[value.id]) {
                    res[value.id] = {
                        id: value.id,
                        equipe_id: value.equipe_id,
                        funcionario_id: value.funcionario_id,
                        valor_venda: value.valor_venda,
                        nome: value.funcionario.nome,
                        imagem: value.funcionario.imagem,
                        Diacreated_at: new Date(value.created_at).getDate(),
                       // Semanacreated_at: new Date(value.created_at).getDay(),
                       // Mescreated_at: new Date(value.created_at).getMonth()+1,
                    };
                    result.push(res[value.id])
                       // if(res[value.id].Mescreated_at > 9){
                       //     if(res[value.id].Diacreated_at >=  diaAtual - res[value.id].Semanacreated_at  && res[value.id].Diacreated_at <= diaAtual){
                       //         console.log(diaAtual -res[value.id].Semanacreated_at)
                       //          result.push(res[value.id])
                       //     }else{
                       //         console.log(diaAtual -res[value.id].Semanacreated_at)
                       //     }

                       // }
                }
                return res;
            }, {});
            return result
        },
        // fim metodo filtrar vendas por data --------------------------------------------------------------------------

    },
    mounted() {
        this.carregarListaVenda();
    }
}
</script>

