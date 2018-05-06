require("./bootstrap");

window.Vue = require("vue");

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("flash", require("./components/Flash.vue"));
Vue.component("paginator", require("./components/Paginator.vue"));
Vue.component("thread-view", require("./pages/Thread.vue"));

const app = new Vue({
  el: "#app"
});
