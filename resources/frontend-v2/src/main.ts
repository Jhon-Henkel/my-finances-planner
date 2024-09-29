import {createApp} from 'vue'
import App from './App.vue'
import router from './router'
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
import './theme/variables.css'
import moneyMask from "@/directives/mask/money/moneyMask"
import * as Sentry from "@sentry/vue"

Sentry.init({
    dsn: process.env.VITE_SENTRY_DSN_PUBLIC,
    integrations: [
        Sentry.replayIntegration(),
    ],
    tracePropagationTargets: [
        `${process.env.VITE_API_BASE_URL}`
    ],
    replaysSessionSampleRate: 0.1,
    replaysOnErrorSampleRate: 1.0,
    beforeSend(event: any) {
        if (event.exception) {
            const exception = event.exception.values[0]
            if (exception.mechanism && exception.mechanism.data && exception.mechanism.data.status_code) {
                const statusCode = exception.mechanism.data.status_code;
                if (statusCode === 401 || statusCode === 403 || statusCode === 503) {
                    return null
                }
            }
            Sentry.showReportDialog({
                eventId: event.event_id,
            });
        }
        return event
    }
});

const app = createApp(App)
    .directive('money', moneyMask)
    .use(IonicVue)
    .use(router)
    .use(createPinia())

router.isReady().then(() => {
    app.mount('#ionic-app')
})
