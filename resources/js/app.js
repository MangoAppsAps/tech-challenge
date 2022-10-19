/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from "vue";

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
Vue.component('clients-list', require('./components/ClientsList.vue').default);
Vue.component('client-form', require('./components/ClientForm.vue').default);
Vue.component('client-show', require('./components/ClientShow.vue').default);
Vue.component('base-pagination', require('./components/BasePagination.vue').default);

Vue.mixin({
    methods: {
        processServerError(error) {
            switch (error.response.status) {
                case 422:
                    let errors = error.response.data.errors;

                    for (let field in errors) {
                        errors[field] = errors[field][0];
                    }

                    return errors;
                case 401:
                    alert('Your session expired, please log in again.');
                    break;
                case 403:
                    alert('Action forbidden.');
                    break;
                default:
                    alert('Sorry - something bad happened, but we\'re working on it!');
                    break;
            }
        }
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
