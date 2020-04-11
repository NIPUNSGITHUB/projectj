/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueRouter from "vue-router";
import Notifications from 'vue-notification'
Vue.use(VueRouter);
Vue.use(Notifications)

Vue.component('pagination', require('laravel-vue-pagination'));
 
const routes = [
    { path: '/', component: require('./components/DashboardComponent.vue').default }, 

]
 
const router = new VueRouter({
    routes 
  })
    
Vue.component('customer-placeorder-component',require('./components/Customer/CustomerIndex.vue').default);
Vue.component('supplier-component',require('./components/Supplier/SupplierIndex.vue').default);
 
Vue.prototype.$user = document.querySelector("meta[name='user']").getAttribute('content');

const app = new Vue({
    el: '#app',
    router
});
