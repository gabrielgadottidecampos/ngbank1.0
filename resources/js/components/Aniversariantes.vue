<template>
    <div class="containerCentralizado ">
        <div class="row bootstrap snippets bootdeys ">
            <div class="col-md-4 container-widget">
                <div class="panel panel-info panel-widget">
                    <div class="panel-title text-center">
                        Aniversariantes Do Dia
                    </div>
                    <div class="panel-body" v-for="a in filtrarMelhoresDoDia()">
                        <ul class="basic-list image-list">
                            <li><img v-bind:src="/storage/+a.imagem " class="img"  width="200" height="200"><b>{{a.nome}}</b><span class="desc">{{a.valor_venda}}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-4 container-widget">
                <div class="panel panel-success panel-widget">
                    <div class="panel-title text-center">
                        Aniversariantes Do Mês
                    </div>
                    <div class="panel-body">
                        <ul class="basic-list image-list">
                            <li><img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="img" class="img"><b>John Doe</b><span class="desc">Designer</span></li>
                        </ul>
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

.container-widget .panel {
    margin-bottom: 15px;
    border-radius: 0px;
    border: 5px #e6e9ee solid;
}

.panel-info {
    background: #3f51b5 url(http://themesground.com/modern/demo1/HTML/img/intro-bg.png) repeat top left;
    color: #fff;
}

.panel-success {
    background: #1ab394 url(http://themesground.com/modern/demo1/HTML/img/intro-bg.png) repeat top left;
    color: #fff;
}

.panel-widget {
    overflow: hidden;
    border: none;
}

.panel .panel-title {
    color: #58666e;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 0px;
}
.panel-title {
    font-family: 'Montserrat', sans-serif;
    color: #58666e;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
    padding: 16px 20px;
    margin: -20px;
    background: #fff;
    margin-bottom: 5px;
    border-bottom: none;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    letter-spacing: 1px;
}
.panel-title {
    margin-top: 0;
    margin-bottom: 0;
    font-size: 16px;
    color: inherit;
}
.basic-list {
    margin-bottom: 0;
    padding: 0;
}

ul, ol {
    margin-top: 0;
    margin-bottom: 10px;
}

/* Basic List */
.basic-list {
    margin-bottom: 20px;
    padding: 0;
}
.basic-list li {
    display: block;
    position: relative;
    padding: 25px 0;
}
.basic-list li:last-child {
    border-bottom: none;
}
.basic-list .right {
    position: absolute;
    right: 0;
    display: inline-block;
    padding: 3px 6px;
    font-weight: 600;
}

/* Image List */
.image-list li {
    padding-left: 120px;
}
.image-list .img {
    width: 100px;
    height: 100px;
    position: absolute;
    left: 0;
    border-radius: 20px;
}
.image-list .desc {
    font-size: 12px;
    opacity: 0.8;
    display: block;
}
.containerCentralizado {
    margin-left: auto;
    margin-right: auto;
}
</style>
