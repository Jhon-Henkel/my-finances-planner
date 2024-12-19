import {createApp} from 'vue'
import App from './App.vue'
import router from './infra/router'
import {IonicVue} from '@ionic/vue'
import {createPinia} from 'pinia'
import '@ionic/vue/css/core.css'
import '@ionic/vue/css/normalize.css'
import '@ionic/vue/css/structure.css'
import '@ionic/vue/css/typography.css'
import '@ionic/vue/css/padding.css'
import '@ionic/vue/css/float-elements.css'
import '@ionic/vue/css/text-alignment.css'
import '@ionic/vue/css/text-transformation.css'
import '@ionic/vue/css/flex-utils.css'
import '@ionic/vue/css/display.css'
import '@ionic/vue/css/palettes/dark.system.css'
import '@/infra/theme/variables.css'
import moneyMask from "@/infra/directives/mask/money/moneyMask"

const app = createApp(App)
    .directive('money', moneyMask)
    .use(IonicVue)
    .use(router)
    .use(createPinia())

router.isReady().then(() => {
    app.mount('#ionic-app')
})
