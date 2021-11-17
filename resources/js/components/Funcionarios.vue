<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Botão adicionar funcionarios -->
                <div class="d-md-flex justify-content-md-end mb-2">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalFuncionario">
                        <i class="fas fa-user-plus"></i>
                    </button>
                </div>
                <!-- Fim Botão adicionar funcionarios -->
                <!-- inicio card funcionario -->
                <card-component titulo="Funcionarios">
                    <!-- Inicio templete conteudo-->
                    <template v-slot:conteudo>
                        Conteudo aqui
                    </template>
                    <!--fim templete conteudo -->
                    <!-- inicio template rodapé -->
                    <template v-slot:rodape>
                    </template>
                    <!-- fim template rodapé -->
                </card-component>
                <!-- Fim Card Funcionario -->
            </div>
        </div>
        <!--Inicio modal cadastro funcionario -->
        <modal-component id="modalFuncionario" titulo="Adicionar Funcionario">
            <!--inicio do templete de alertas -->
            <template v-slot:alertas>
            </template>
            <!--fim do templete de alertas -->
            <!--Inicio do template conteudo -->
            <template v-slot:conteudo>
                <form>
                    <div class="form-group">
                        <input-container-component titulo="Nome do Funcionario" id="novoNome" id-help="novoNomeHelp"
                                                   texto-ajuda="Informe o nome do Funcionario">
                            <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                                   placeholder="Nome do Funcionario" v-model="nomeFuncionario">
                        </input-container-component>
                       <!-- ************************************************************************************************** -->

                    </div>
                    <!--inicio div de seleção de imagem -->
                    <div class="form-group">
                        <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp"
                                                   texto-ajuda="Selecione uma imagem no formato PNG">
                            <input type="file" class="form-control-file" id="novoImagem"
                                   aria-describedby="novoImagemHelp" placeholder="Selecione uma imagem"
                                   @change="carregarImagem($event)">
                        </input-container-component>
                        {{ arquivoImagem }}
                    </div>
                    <!--Fim div de seleção de imagem -->
                    <!-- inicio div data venda -->
                    <div class="form-group">
                        <input-container-component titulo="Dt Nascimento" id="novaData" id-help="novaDataHelp"
                                                   texto-ajuda="Informe a data de nascimento">
                            <input type="text" class="form-control" id="novaData" aria-describedby="novaDataHelp"
                                   placeholder="data de Aniversario" v-model="dtNasdcimento">
                        </input-container-component>
                        {{ dtNasdcimento }}
                    </div>
                    <!-- fim div data venda -->
                    <!-- inicio seleção de equipes -->
                    <div class="form-group">
                        <label>Selecione uma Equipe</label>
                        <select id="inputState" class="form-control" @select="setStore(obj)">
                            <option selected>Equipes</option>
                            <option v-for="obj in teste">{{obj.nome}}</option>
                        </select>
                    </div>

                    <!-- fim seleção de equipes -->
                </form>
            </template>
            <!--Fim do template conteudo -->

            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" @click=" salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
        <!--Fim modal cadastro funcionario -->

        <!--Inicio modal visualizar funcionario -->
        <!--Fim modal visualizar funcionario -->
        <!--Inicio modal editar funcionario -->
        <!--Fim modal editar funcionario -->
        <!--Inicio modal Excluir funcionario -->
        <!--Fim modal Excluir Funcionario -->

    </div>
</template>

<script>
export default {

    computed: {

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
                urlBaseEquipe: 'http://127.0.0.1:8000/api/v1/equipe',
                urlBase: 'http://127.0.0.1:8000/api/v1/funcionario',
                idEquipe: '',
                nomeFuncionario: '',
                dtNasdcimento: '',
                arquivoImagem: [],
                equipes: [],
                teste:[]
            }
        },
        methods: {

        //**************************************************************************************************************
            carregarListaEquipe() {

                let config = {
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': this.token
                    }
                }

                console.log(this.urlBaseEquipe)
                axios.get(this.urlBaseEquipe, config)
                    .then(response => {
                        this.equipes = response.data
                        this.teste = this.equipes.data
                    })
                    .catch(errors => {
                        console.log(errors)
                    })
            },
        //--------------------------------------------------------------------------------------------------------------

            carregarImagem(e) {
                this.arquivoImagem = e.target.files
            },
            setStore(obj) {
              console.log(obj)
            },
            salvar() {
                console.log(this.teste.setStore(obj))
                //console.log(this.nomeFuncionario, this.arquivoImagem, this.dtNasdcimento, this.teste)
            }
        },
    mounted() {
        this.carregarListaEquipe()
    }
    }
</script>
