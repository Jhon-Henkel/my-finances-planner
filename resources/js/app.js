import 'primevue/resources/themes/aura-light-green/theme.css'
import '../sass/app.scss'
import './bootstrap'
import '../css/app.css'
import '../font/poppins.css'
import { createApp } from 'vue'
import app from '../vue/App.vue'
import router from './router'
import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { fas } from '@fortawesome/free-solid-svg-icons'
import { fab } from '@fortawesome/free-brands-svg-icons'
import tooltip from '../directives/tooltip/tooltip.js'
import PrimeVue from 'primevue/config';
import '../directives/tooltip/tooltip.css'
import moneyMask from '../directives/moneyMask/moneyMask'
import { createPinia } from 'pinia'

library.add(fas, fab)
const pinia = createPinia()
const appCreated = createApp(app)
appCreated.directive('tooltip', tooltip)
appCreated.directive('money', moneyMask)
appCreated.component('font-awesome-icon', FontAwesomeIcon)
appCreated.use(router)
appCreated.use(PrimeVue)
appCreated.use(pinia)
appCreated.mount('#app')