<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {IonCol, IonIcon, IonRow, modalController, IonLabel, IonGrid, IonButton} from "@ionic/vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {onMounted, ref} from "vue"
import MfpInput from "@/components/input/MfpInput.vue"
import MfpInputToggle from "@/components/input/MfpInputToggle.vue"
import {alertCircleOutline} from "ionicons/icons"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import {UserService} from "@/services/user/UserService"
import {useAuthStore} from "@/stores/auth/AuthStore"
import {UserSettingsFormValidation} from "@/form-validation/settings/user/UserSettingsFormValidation"
import {AuthService} from "@/services/auth/AuthService"
import router from "@/router"
import {MfpSubscriptionService} from "@/services/subscription/MfpSubscriptionService"

const userSettings = ref(UserService.makeEmptyUser())
const alterPassword = ref(false)
const atualPassword = ref('')
const password = ref('')
const confirmPassword = ref('')
const authStore = useAuthStore()

async function save() {
    let okMessage = new MfpOkAlert('Ação não permitida')
    if (alterPassword.value && password.value !== confirmPassword.value) {
        await okMessage.open('A nova senha e a senha de confirmação não são iguais!')
        return
    }
    if (alterPassword.value && atualPassword.value === '') {
        await okMessage.open('A senha atual não confere!')
        return
    }
    if (alterPassword.value) {
        userSettings.value.password = password.value
        userSettings.value.current_password = atualPassword.value
    }
    const validationResult = UserSettingsFormValidation.validate(userSettings.value)
    if (!validationResult.isValid) {
        return
    }
    await UserService.update(authStore.getUserId.value, userSettings.value)
    okMessage = new MfpOkAlert('Usuário Salvo!')
    await okMessage.open('Faça o login novamente!')
    await AuthService.logout()
    closeModal()
    await router.push({ name: 'login' }).then(() => {
        window.location.reload();
    });}

function closeModal() {
    modalController.dismiss()
}

onMounted(async () => {
    userSettings.value = await UserService.get(authStore.getUserId.value)
})
</script>

<template>
    <mfp-modal-header title="Config. do Usuário" @close-action="closeModal" @save-action="save"/>
    <mfp-modal-content :show-content="(password != '' && confirmPassword != '') && (password != confirmPassword)">
        <template #list>
            <mfp-input v-model="userSettings.name" label="Nome" placeholder="Seu Nome"/>
            <mfp-input v-model="userSettings.email" label="E-mail" placeholder="Seu E-mail" type="email"/>
            <mfp-input-toggle v-model="alterPassword" label="Alterar Senha"/>
            <mfp-input v-model="atualPassword"
                       label="Senha Atual"
                       placeholder="Senha Atual"
                       type="password"
                       v-if="alterPassword"
            />
            <mfp-input v-model="password"
                       label="Nova Senha"
                       placeholder="Nova senha"
                       type="password"
                       v-if="alterPassword"
            />
            <mfp-input v-model="confirmPassword"
                       label="Confirme a Nova Senha"
                       placeholder="Confirme a nova senha"
                       type="password"
                       v-if="alterPassword"
            />
        </template>
        <template #content>
            <ion-row class="center-ion-label-content">
                <ion-col size="2">
                    <ion-icon :icon="alertCircleOutline" size="large" class="ion-margin-end" color="danger"/>
                </ion-col>
                <ion-col size="10">
                    <ion-label>
                        <p>
                            As Senhas digitadas não conferem! Verifique as senhas digitadas e tente novamente!
                        </p>
                    </ion-label>
                </ion-col>
            </ion-row>
        </template>
        <template #footer>
            <ion-grid>
                <ion-row>
                    <ion-col>
                        <ion-button
                            expand="block"
                            @click="MfpSubscriptionService.openModal('', false)"
                        >
                            Gerenciar Plano
                        </ion-button>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </template>
    </mfp-modal-content>
</template>
