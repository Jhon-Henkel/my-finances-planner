import '../sass/app.scss';
import './bootstrap';
import '../css/app.css';
import * as bootstrap from 'bootstrap';
import { createApp } from "vue";
import app from "../vue/App.vue";
import login from "../vue/Login.vue";
import router from "./router";
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";
import tooltip from "../directives/tooltip/tooltip.js";
import "../directives/tooltip/tooltip.css";
import moneyMask from "../directives/moneyMask/moneyMask";

library.add(fas, far)

const appCreated = createApp(app)
appCreated.directive("tooltip", tooltip);
appCreated.directive("money", moneyMask);
appCreated.component('font-awesome-icon', FontAwesomeIcon).use(router).mount("#app")

const appCreatedLogin = createApp(login)
appCreatedLogin.component('font-awesome-icon', FontAwesomeIcon).use(router).mount("#login");