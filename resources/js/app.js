import './bootstrap';
import '../css/app.css';
import { createApp } from "vue";
import app from "../vue/App.vue";
import router from "./router";
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from "@fortawesome/free-solid-svg-icons";
import { far } from "@fortawesome/free-regular-svg-icons";

library.add(fas, far)

createApp(app).component('font-awesome-icon', FontAwesomeIcon).use(router).mount("#app")