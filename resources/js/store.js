import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        // Define tus estados iniciales aquí
        products: []
    },
    mutations: {
        // Define tus mutaciones aquí
        UPDATE_PRODUCTS(state, newProducts) {
            state.products = newProducts;
        }
    },
    // ...otros módulos o configuraciones adicionales
});

export default store;

const app = new Vue({
    el: '#app',
    store,
});
