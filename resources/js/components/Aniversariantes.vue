<template>
    <div class="container">

        <main class="container">
            <figure class="avatar">
                <img class="fundoImagem" src="https://image.freepik.com/vetores-gratis/cartao-quadro-redondo-e-baloes_1262-4245.jpg">
                <img class="imagemFuncionario" src="/storage/imagens/funcionarios/6WJxjGMUKGeUiZQKkWlth9A7rq9lINp4vNMViZi0.png">
            </figure>
        </main>
        <!--
        {{filtrarMelhoresDoDia()}}
        -->
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
            urlBaseFuncionario: 'http://127.0.0.1:8000/api/v1/funcionario',
            funcionarios: [],
        }
    },
    methods: {
        carregarListaFuncionario() {
            let url = this.urlBaseFuncionario + '?' + this.urlPaginacao + this.urlFiltro
            axios.get(url)
                .then(response => {
                    this.funcionarios = response.data.data
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        AdicionarData() {
            var ArrayvendasDia = this.funcionarios;
            var result = [];
            ArrayvendasDia.reduce(function (res, value) {
                if (!res[value.id]) {
                    res[value.id] = {
                        id: value.id,
                        nome: value.nome,
                        imagem: value.imagem,
                        data_nascimento: new Date(value.data_nascimento).getUTCMonth() + 1,
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
                if (value.data_nascimento == data.getMonth() + 1) {
                    if (!res[value.id]) {
                        res[value.id] = {
                            nome: value.nome,
                            imagem: value.imagem,
                            data_nascimento: value.data_nascimento
                        };
                        result.push(res[value.id])
                    }
                }

                return res;
            }, {});
            return result
        },
    },
    mounted() {
        this.carregarListaFuncionario()
    }
}
</script>
<style>
.container figure.avatar{
    width: 240px;
    height: 240px;
    border-radius: 50%;
    box-shadow: 0 0 15px black;

}
.container figure.avatar img{
    position: absolute;
    left: 50%;
    right: 50%;
}
.imagemFuncionario{
    height: 250px;
    width: 250px;
    border-radius: 60%;
    position: center;
    margin-left: auto;
    margin-right: auto;
    left: 50%;
    right: 50%;
    top:50%
}
</style>
