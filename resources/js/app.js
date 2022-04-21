require('./bootstrap');

window.Vue = require('vue').default

import App from './App.vue'
import router from './router/index'
import store from './store/index'
import helpers from './helpers/helpers'
import Toasted from 'vue-toasted'

Vue.use(Toasted, {
  duration: 3000
})

const app = new Vue({
    store,
    router,
    render: h => h(App)
}).$mount('#app');
