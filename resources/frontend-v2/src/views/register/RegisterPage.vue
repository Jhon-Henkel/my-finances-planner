<script setup lang="ts">
import {IonCol, IonGrid, IonRow} from "@ionic/vue"
import MfpRegisterTopText from "@/views/register/MfpRegisterTopText.vue"
import {lockClosedOutline, mailOutline, personOutline} from "ionicons/icons"
import {ref} from "vue"
import MfpRegisterButton from "@/views/register/MfpRegisterButton.vue"
import MfpLoginLink from "@/views/register/MfpLoginLink.vue"
import MfpPasswordsNotMathMessage from "@/views/register/MfpPasswordsNotMathMessage.vue"
import router from "../../infra/router"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import {RegisterService} from "@/services/register/RegisterService"
import {UserRegisterFormValidation} from "@/form-validation/register/UserRegisterFormValidation"
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpTermsAndPrivacyText from "@/views/terms-and-policy/MfpTermsAndPrivacyText.vue"

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
        await router.push({name: 'register-done', query: {email: email}})
        return
    }
    const okAlert = new MfpOkAlert('Dados Inválidos!')
    await okAlert.open(result.data)
}
</script>

<template>
    <mfp-page>
        <ion-grid class="register-grid">
            <div class="content">
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
            </div>
            <ion-row class="footer">
                <ion-col size="1"/>
                <ion-col size="10">
                    <mfp-terms-and-privacy-text action="registrar"/>
                </ion-col>
                <ion-col size="1"/>
            </ion-row>
        </ion-grid>
    </mfp-page>
</template>

<style scoped>
.register-grid {
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
