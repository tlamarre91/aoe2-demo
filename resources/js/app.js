/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');
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

//import ExampleComponent from "./components/ExampleComponent.vue";
//import CivilizationCard from "./components/CivilizationCard.vue";
import CivilizationList from "./components/CivilizationList.vue";
import App from "./components/App.vue";

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//Vue.component('civilization-card', require('./components/CivilizationCard.vue').default);
//const CivilizationList = require('./components/CivilizationList.vue').default;
Vue.component('civilization-list', CivilizationList);
Vue.component('App', App);
Vue.config.productionTip = false;

function main() {
  const app = new Vue({
    el: '#app',
    template: "<App/>",
    created: function () {
      console.log("created");
    },

    beforeCreate: function () {
      console.log('before create');
    },

    mounted: function () {
      console.log("mounted");
    }
  });
}

document.addEventListener("DOMContentLoaded", main);
