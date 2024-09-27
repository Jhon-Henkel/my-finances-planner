<script setup lang="ts">
import {IonCol, IonGrid, IonRow} from "@ionic/vue"
import {onMounted, ref} from "vue"
import {lockClosedOutline, mailOutline} from "ionicons/icons"
import MfpCreateAccountLink from "@/views/login/MfpCreateAccountLink.vue"
import MfpForgottenPasswordLink from "@/views/login/MfpForgottenPasswordLink.vue"
import MfpLoginTopText from "@/views/login/MfpLoginTopText.vue"
import MfpLoginButton from "@/views/login/MfpLoginButton.vue"
import MfpInput from "@/components/input/MfpInput.vue"
import MfpPage from "@/components/page/MfpPage.vue"
import {AuthService} from "@/services/auth/AuthService"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import {LoginFormValidation} from "@/form-validation/auth/login/LoginFormValidation"
import {UtilApp} from "@/util/UtilApp"
import router from "@/router"
import MfpTermsAndPrivacyText from "@/views/terms-and-policy/MfpTermsAndPrivacyText.vue"

const loginData = ref(AuthService.emptyLoginObject())
loginData.value.email = AuthService.getRememberedEmail()
const loading = ref(false)

async function submit() {
    const okAlert = new MfpOkAlert("Dados inválidos!")
    const validationResult = LoginFormValidation.validate(loginData.value)
    if (!validationResult.isValid) {
        return
    }
    loading.value = true
    const login = await AuthService.login(loginData.value)
    if (login.isSuccess) {
        loginData.value.password = ''
        if (login.data.must_show_welcome_page) {
            await router.push({name: 'welcome'})
            return
        }
        const urlParams = new URLSearchParams(window.location.search)
        const redirect: string | null = urlParams.get('redirect')
        loading.value = false
        await router.push({name: redirect ?? 'dashboard'})
        return
    }
    loading.value = false
    await okAlert.open(login.data)
}

onMounted(async () => {
    if (AuthService.isUserLogged()) {
        await router.push({name: 'dashboard'})
        return
    }
    if (UtilApp.isAppInDemoMode()) {
        loginData.value.email = 'mfp-demo@jhon.dev.br'
        loginData.value.password = 'mfp-demo'
    } else if (UtilApp.isAppInDeveloperMode()) {
        loginData.value.email = 'demo@demo.dev'
        loginData.value.password = '12345678'
    }
})
</script>

<template>
    <mfp-page>
        <ion-grid class="login-grid">
            <div class="content">
                <mfp-login-top-text/>
                <ion-row>
                    <ion-col size="1"/>
                    <ion-col size="10">
                        <mfp-input
                            type="email"
                            label="E-mail"
                            placeholder="Seu E-mail"
                            v-model="loginData.email"
                            :icon="mailOutline"
                        />
                        <mfp-input
                            type="password"
                            label="Senha"
                            placeholder="Sua Senha"
                            v-model="loginData.password"
                            :icon="lockClosedOutline"
                        />
                    </ion-col>
                    <ion-col size="1"/>
                </ion-row>
                <mfp-forgotten-password-link v-show="false"/>
                <mfp-login-button :loading="loading" @loginPressed="submit"/>
                <mfp-create-account-link/>
            </div>
            <ion-row class="footer">
                <ion-col size="1"/>
                <ion-col size="10">
                    <mfp-terms-and-privacy-text action="logar"/>
                </ion-col>
                <ion-col size="1"/>
            </ion-row>
        </ion-grid>
    </mfp-page>
</template>

<style scoped>
.login-grid {
    display: flex;
    flex-direction: column;
    min-height: 94vh;
}

.content {
    flex: 1;
}

.footer {
    margin-top: auto;
}
</style>
