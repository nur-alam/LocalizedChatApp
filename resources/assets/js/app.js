/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('chat-app', require('./components/chatApp'));
Vue.component('people',require('./components/peopleYouMayKnow'));
Vue.component('Conversation', require('./components/Conversation'));
Vue.component('ContactList', require('./components/Contactlist'));
Vue.component('places', require('./components/places'));

import VueSelect from 'vue-cool-select'
Vue.use(VueSelect,{
    theme : 'bootstrap'
})

let moment = require('moment');
moment().format();

Vue.filter('momentdate',(date)=>{
    return moment(date).utc(date).local().fromNow();
});

const app = new Vue({
    el: '#app',
});