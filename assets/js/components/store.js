import Vue from 'vue';
import Vuex from 'vuex';
import axios from 'axios';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    forSale: [],
    inCart: [],
    user: null,
  },
  getters: {
    forSale: state => state.forSale,
    inCart: state => state.inCart,
    user (state) { 
      console.log(state.user);
      return state.user;
    },
  },
  mutations: {
    ADD_TO_CART(state, invId) { state.inCart.push(invId); },
    REMOVE_FROM_CART(state, index) { state.inCart.splice(index, 1); },
    SET_PRODUCT (state, forSale) { state.forSale = forSale },
    REGISTER_USER (state, payload) {
      const id = payload.id
      if (state.user.registeredMeetups.findIndex(meetup => meetup.id) >= 0 ) {
        return
      }
      state.user.registeredMeetups.push(id)
      state.user.fbKeys[id] = payload.fbKey
    },
    UNREGISTER_USER (state, payload) {
      const registeredMeetups = state.user.registeredMeetups
      registeredMeetups.splice(registeredMeetups.findIndex(meetup => meetup.id === payload), 1)
      Reflect.deleteProperty(state.user.fbKeys, payload)
    },
    SET_USER (state, payload) {
      state.user = payload
    }
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