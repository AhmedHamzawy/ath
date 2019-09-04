
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VeeValidate, { Validator } from 'vee-validate';
import ar from 'vee-validate/dist/locale/ar';
import * as VueGoogleMaps from 'vue2-google-maps'

window.Vue = require('vue');
Vue.use(VeeValidate);
Validator.localize('ar', ar);
Vue.use(VueGoogleMaps, {
    load: {
      key: 'AIzaSyDqET1nIDZzMGEieGANkEF_xB1RSCkJTjk',
      libraries: 'places',
      language: 'ar',
    },   
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('services', require('./components/Services.vue'));
Vue.component('states', require('./components/States.vue'));
Vue.component('statuses', require('./components/Statuses.vue'));
Vue.component('hospitals', require('./components/Hospitals.vue'));
Vue.component('doctors', require('./components/Doctors.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('users', require('./components/Users.vue'));
Vue.component('settings', require('./components/Settings.vue'));
Vue.component('orders', require('./components/Orders.vue'));
Vue.component('hospitalorders', require('./components/HospitalOrders.vue'));
Vue.component('contacts', require('./components/Contacts.vue'));
Vue.component('comments', require('./components/Comments.vue'));
Vue.component('ratings', require('./components/Ratings.vue'));
Vue.component('bankaccounts', require('./components/BankAccounts.vue'));
Vue.component('invoice', require('./components/Invoice.vue'));


// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key)))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
