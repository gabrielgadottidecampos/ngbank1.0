<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- -->
                <!-- Botão Adicionar ------------------------------------------------------------------------------- -->
                <div class="mb-3">
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalEquipe">
                        Adicionar
                    </button>
                </div>
                <!--fim botão adicionar ---------------------------------------------------------------------------- -->
                <card-component titulo="Equipes">
                    <template v-slot:conteudo>
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Foto</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                            </tr>
                            <tr>
                                <th scope="row">2</th>
                                <td>Jacob</td>
                                <td>Thornton</td>
                            </tr>
                            </tbody>
                        </table>
                    </template>
                </card-component>
            </div>
        </div>
        <!-- modal -->
        <modal-component id="modalEquipe" titulo="Adicionar Equipe">
            <!-- alertas template -->
            <template v-slot:alertas>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso" v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao tentar cadastrar a equipe" v-if="transacaoStatus == 'erro'"></alert-component>
            </template>
            <!-- fim alertas template -->
            <!-- form modal -->
            <template v-slot:conteudo>

                <div class="form-group">
                    <!-- input nome da equipe -->
                    <input type="text" class="form-control" id="novoNome" placeholder="Nome da Equipe"
                           v-model="nomeEquipe">
                    {{ nomeEquipe }}
                    <!-- fim input nome da equipe -->
                    <!-- input imagem -->
                    <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input" id="novaImagem" lang="pt"
                               @change="carregarImagem($event)">
                        <label class="custom-file-label" for="novaImagem">Selecione uma Imagem</label>
                        {{ arquivoImagem }}
                    </div>
                    <!-- fim input imagem -->
                </div>
            </template>
            <!-- fim form modal -->
            <template v-slot:rodape>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" @click="salvar()">Salvar</button>
                </div>
            </template>
        </modal-component>
        <!-- fim do modal -->

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
            urlBase: 'http://127.0.0.1:8000/api/v1/equipe',
            nomeEquipe: '',
            arquivoImagem: [],
            transacaoStatus: '',
            transacaoDetalhes: []
        }
    },
    methods: {
        carregarImagem(e) {
            this.arquivoImagem = e.target.files
        },
        salvar() {
            console.log(this.nomeEquipe, this.arquivoImagem[0])

            let formData = new FormData();
            formData.append('nome', this.nomeEquipe)
            formData.append('imagem', this.arquivoImagem[0])

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Accept': 'application/json',
                    'Authorization': this.token
                }
            }

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = response
                    console.log(response)
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = errors.response
                    console.log(errors)
                })
        }
    }
}
</script>
