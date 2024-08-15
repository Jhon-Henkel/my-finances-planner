<script setup lang="ts">
import {IonCol, IonGrid, IonRow} from "@ionic/vue"
import MfpRegisterTopText from "@/views/register/MfpRegisterTopText.vue"
import {lockClosedOutline, mailOutline, personOutline} from "ionicons/icons"
import {ref} from "vue"
import MfpRegisterButton from "@/views/register/MfpRegisterButton.vue"
import MfpLoginLink from "@/views/register/MfpLoginLink.vue"
import MfpPasswordsNotMathMessage from "@/views/register/MfpPasswordsNotMathMessage.vue"
import router from "@/router"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import {RegisterService} from "@/services/register/RegisterService"
import {UserRegisterFormValidation} from "@/form-validation/register/UserRegisterFormValidation"
import MfpPage from "@/components/page/MfpPage.vue"
import MfpInput from "@/components/input/MfpInput.vue"

const registerData = ref(RegisterService.emptyRegisterData())

async function register() {
    const validationResult = UserRegisterFormValidation.validate(registerData.value)
    if (!validationResult.isValid) {
        return
    }
    const result = await RegisterService.register(registerData.value)
    if (result.isSuccess) {
        const email = registerData.value.email
        registerData.value = RegisterService.emptyRegisterData()
        router.push({name: 'register-done', query: {email: email}})
        return
    }
    const okAlert = new MfpOkAlert('Dados Inválidos!')
    await okAlert.open(result.data)
}
</script>

<template>
    <mfp-page>
        <ion-grid>
            <mfp-register-top-text/>
            <mfp-passwords-not-math-message :register-data="registerData"/>
            <ion-row>
                <ion-col size="1"/>
                <ion-col size="10">
                    <mfp-input
                        v-model="registerData.name"
                        label="Seu Nome"
                        placeholder="Seu nome completo"
                        :icon="personOutline"
                    />
                    <mfp-input
                        type="email"
                        label="E-mail"
                        placeholder="Seu E-mail"
                        v-model="registerData.email"
                        :icon="mailOutline"
                    />
                    <mfp-input
                        type="password"
                        label="Senha"
                        placeholder="Digite sua senha"
                        v-model="registerData.password"
                        :icon="lockClosedOutline"
                    />
                    <mfp-input
                        type="password"
                        label="Confirme a senha"
                        placeholder="Confirme a senha digitada"
                        v-model="registerData.confirmPassword"
                        :icon="lockClosedOutline"
                    />
                </ion-col>
                <ion-col size="1"/>
            </ion-row>
            <mfp-register-button @register-pressed="register"/>
            <mfp-login-link/>
        </ion-grid>
    </mfp-page>
</template>
