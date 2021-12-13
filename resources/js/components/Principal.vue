<template>
    <div class="container">
        <ul class="list-group">
            <li class="list-group-item">An item</li>
        </ul>

        {{funcionarios}}
        <button type="button" class="btn btn-primary" @click="teste()">Atualizar</button>
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
            urlBaseFuncionario: 'http://127.0.0.1:8000/api/v1/venda',
            funcionarios: [],
            mes: '',
            arra: []
        }
    },
    methods: {

        carregarFuncionarioLista() {

            axios.get(this.urlBaseFuncionario)
                .then(response => {
                    console.log(this.funcionarios = response.data)
                        this.funcionarios.forEach((valor)=>{
                            console.log(valor.funcionario.nome)

                        })
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        onChangeMethod(event) {
            this.equipe_id = event.target.value;
            console.log(this.equipe_id);
            this.refsss = this.$refs


        },
        teste(){

        }

    },
    mounted() {

         this.carregarFuncionarioLista()
    }
}
</script>


