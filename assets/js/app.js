import Vue from 'vue';
import App from './components/App.vue';
import store from './components/store.js';

/* eslint-disable no-new */
new Vue({
  el: '#app',
  store,
  render: h => h(App),
});