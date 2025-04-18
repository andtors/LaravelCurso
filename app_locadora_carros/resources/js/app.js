/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import './bootstrap';
import { createApp } from 'vue';
import { createStore } from 'vuex'


const store = createStore({
    state() {
        return{
            item: {},
            transacao: { status: '', mensagem: '', dados: '' }
        }
    }
})

const app = createApp({
    store
})

app.use(store)


/**
 * Next, we will create a fresh Vue application instance. You may then begin
 * registering components with the application instance so they are ready
 * to use in your application's views. An example is included for you.
 */

import Home from './components/Home.vue';
app.component('home-component', Home);
import Login from './components/Login.vue';
app.component('login-component', Login);
import Register from './components/Register.vue';
app.component('register-component', Register);
import Marcas from './components/Marcas.vue';
app.component('marcas-component', Marcas);
import InputContainer from './components/InputContainer.vue';
app.component('input-container-component', InputContainer);
import Table from './components/Table.vue';
app.component('table-component', Table);
import Card from './components/Card.vue';
app.component('card-component', Card);
import Modal from './components/Modal.vue';
app.component('modal-component', Modal);
import Alert from './components/Alert.vue';
app.component('alert-component', Alert);
import Paginate from './components/Paginate.vue';
app.component('paginate-component', Paginate);
import Clientes from './components/Clientes.vue';
app.component('clientes-component', Clientes);
import Modelos from './components/Modelos.vue';
app.component('modelos-component', Modelos);
import Carros from './components/Carros.vue';
app.component('carros-component', Carros);
import Locacoes from './components/Locacoes.vue';
app.component('locacoes-component', Locacoes);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

/**
 * Finally, we will attach the application instance to a HTML element with
 * an "id" attribute of "app". This element is included with the "auth"
 * scaffolding. Otherwise, you will need to add an element yourself.
 */

app.mount('#app');
