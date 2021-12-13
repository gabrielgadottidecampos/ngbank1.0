<template>
    <div >
        <table class="table table-hover table-striped carDentroTeste table-bordered">
            <thead class="thead-dark">
            <tr>
                <th scope="col" v-for="t, key in titulos" :key="key">{{ t.titulo }}</th>
                <th v-if="visualizar.visivel || atualizar.visivel || remover.visivel">Ações</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="obj, chave in dadosFiltrados" :key="chave">
                <td v-for="valor, chaveValor in obj" :key="chaveValor">
                    <span v-if="titulos[chaveValor].tipo == 'texto'" class="corFonte">{{ valor }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'nomeFuncionario'" class="corFonte">{{ valor.nome }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'nomeEquipe'" class="corFonte">{{ valor.nome }}</span>
                    <span v-if="titulos[chaveValor].tipo == 'valor'"> R$ {{ valor }}</span>

                    <span v-if="titulos[chaveValor].tipo == 'data'">
                            {{ valor | formataDataTempoGlobal }}
                        </span>
                    <span v-if="titulos[chaveValor].tipo == 'imagem'">
                            <img :src="'/storage/'+valor" width="60" height="60">
                        </span>
                </td>
                <!-- Botões de excluir e editar-->
                <td v-if="visualizar.visivel || atualizar.visivel || remover.visivel">
                    <button v-if="visualizar.visivel" class="btn btn-outline-secondary btn-sm" :data-toggle="visualizar.dataToggle":data-target="visualizar.dataTarget" @click="setStore(obj)">
                        <i class="fas fa-search"></i>
                    </button>
                    <button v-if="atualizar.visivel" class="btn btn-outline-info btn-sm" :data-toggle="atualizar.dataToggle" :data-target="atualizar.dataTarget" @click="setStore(obj)">
                        <i class="far fa-edit"></i>
                    </button>
                    <button v-if="remover.visivel" class="btn btn-outline-danger btn-sm" :data-toggle="remover.dataToggle":data-target="remover.dataTarget" @click="setStore(obj)">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>
<script>
export default {
    props: ['dados', 'titulos', 'atualizar', 'visualizar', 'remover'],
    methods: {
        setStore(obj) {
            this.$store.state.transacao.status = ''
            this.$store.state.transacao.mensagem = ''
            this.$store.state.item = obj;
        }
    },
    computed: {
        dadosFiltrados() {

            let campos = Object.keys(this.titulos)
            let dadosFiltrados = []

            this.dados.map((item, chave) => {

                let itemFiltrado = {}
                campos.forEach(campo => {

                    itemFiltrado[campo] = item[campo] //utilizar a sintaxe de array para atribuir valores a objetos
                })
                dadosFiltrados.push(itemFiltrado)
            })

            return dadosFiltrados //retorne um array de objetos
        }
    }
}
</script>
<style>
.corFonte{
    color: #ffffff;
}
</style>

