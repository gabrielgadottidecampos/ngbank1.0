/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue').default;

/*vueex

 */
import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
    state:{
        item: {},
        transacao:{ status: '', mensagem: ''},
        statusModal: false,
        atualizaPagina: false,
    }
})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('login-component', require('./components/Login.vue').default);
Vue.component('home-component', require('./components/Home.vue').default);
Vue.component('equipes-component', require('./components/Equipes.vue').default);
Vue.component('card-component', require('./components/Card.vue').default);
Vue.component('modal-component', require('./components/Modal.vue').default);
Vue.component('alert-component', require('./components/Alert.vue').default);
Vue.component('table-component', require('./components/table.vue').default);
Vue.component('paginate-component', require('./components/Paginate').default);
Vue.component('inputContainer-component', require('./components/InputContainer.vue').default);
Vue.component('funcionarios-component', require('./components/Funcionarios.vue').default);
Vue.component('botoes-component', require('./components/Botaos.vue').default);
Vue.component('vendas-component', require('./components/Vendas.vue').default);
Vue.component('inicio-component', require('./components/Principal.vue').default);
Vue.component('camarote-component', require('./components/EquipeCamarote.vue').default);
Vue.component('melhoresdodia-component', require('./components/MelhoresDia.vue').default);
Vue.component('melhoresdomes-component', require('./components/MelhoresDoMes.vue').default);
Vue.component('aniversariantes-component', require('./components/Aniversariantes.vue').default);
Vue.component('melhoresdasemana-component', require('./components/MelhoresDaSemana.vue').default);
Vue.component('vendadias-component', require('./components/vendasDia.vue').default);
Vue.component('rankequipecamarote-component', require('./components/RankEquipeCamarote.vue').default);
Vue.component('rankdomes-component', require('./components/RankDoMes.vue').default);
Vue.component('rankdasemana-component', require('./components/RankDaSemana.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.filter('formataDataTempoGlobal', function(d) {
    if(!d) return ''

    d = d.split('T')

    let data = d[0]
    let tempo = d[1]

    //formatando a data
    data = data.split('-')
    data = data[2] + '/' + data[1] + '/' + data[0]

    //formatar o tempo
    tempo = tempo.split('.')
    tempo = tempo[0]

    return data + ' ' + tempo
})
const app = new Vue({
    el: '#app',
    store

});
