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
// import router from "@/router"

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
    loading.value = false
    if (login.isSuccess) {
        loginData.value.password = ''
        // todo - temporário até desenvolver o dashboard em ionic
        window.location.href = '/dashboard'
        // const urlParams = new URLSearchParams(window.location.search)
        // const redirect: string | null = urlParams.get('redirect')
        // await router.push({name: redirect ?? 'dashboard'})
        return
    }
    await okAlert.open(login.data)
}

onMounted(() => {
    if (AuthService.isUserLogged()) {
        // todo - temporário até desenvolver o dashboard em ionic
        window.location.href = '/dashboard'
        // await router.push({name: 'dashboard'})
        return
    }
    const urlParams = new URLSearchParams(window.location.search)
    const demoMode: string | null = urlParams.get('demo-mode')
    if (demoMode === 'true') {
        loginData.value.email = 'mfp-demo@jhon.dev.br'
        loginData.value.password = 'mfp-demo'
    }
})
</script>

<template>
    <mfp-page>
        <ion-grid>
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
            <mfp-forgotten-password-link/>
            <mfp-login-button :loading="loading" @loginPressed="submit"/>
            <mfp-create-account-link/>
        </ion-grid>
    </mfp-page>
</template>
