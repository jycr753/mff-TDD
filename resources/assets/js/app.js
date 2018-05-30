require("./bootstrap");
import "bulma/css/bulma.css";

window.Vue = require("vue");

Vue.component("flash", require("./components/Flash.vue"));
Vue.component("paginator", require("./components/Paginator.vue"));
Vue.component(
  "user-notifications",
  require("./components/UserNotifications.vue")
);
Vue.component("avatar-form", require("./components/AvatarForm.vue"));
Vue.component("wysiwyg", require("./components/Wysiwyg.vue"));
Vue.component("month-selector", require("./components/Mff/MonthSelector.vue"));
Vue.component(
  "amount-count-up-effect",
  require("./components/Mff/AmountCountUpEffect.vue")
);
Vue.component("details-table", require("./components/Mff/DetailsTable.vue"));

Vue.component("thread-view", require("./pages/Thread.vue"));
Vue.component("dashboard-view", require("./pages/Dashboard.vue"));

const app = new Vue({
  el: "#app"
});
