import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    forSale: [],
    inCart: [],
  },
  getters: {
    forSale: state => state.forSale,
    inCart: state => state.inCart,
  },
  mutations: {
    ADD_TO_CART(state, invId) { state.inCart.push(invId); },
    REMOVE_FROM_CART(state, index) { state.inCart.splice(index, 1); },
    SET_PRODUCT (state, forSale) { state.forSale = forSale },
  },
  actions: {
    loadProducts ({ commit }) {
      axios
        .get('http://localhost:9030/products')
        .then(r => r.data.product)
        .then(forSale => {
          commit('SET_PRODUCT', forSale);

        })
    },
    addToCart(context, invId) { context.commit('ADD_TO_CART', invId); },
    removeFromCart(context, index) { context.commit('REMOVE_FROM_CART', index); },
  },
});