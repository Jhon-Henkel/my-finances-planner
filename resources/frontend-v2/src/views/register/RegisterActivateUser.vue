<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import {IonButton, loadingController, IonIcon, IonCol, IonGrid, IonRow, IonText} from "@ionic/vue"
import {ref} from "vue"
import {useRoute} from "vue-router"
import {checkmarkCircleOutline} from "ionicons/icons"
import {ApiRouter} from "@/api/ApiRouter"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"

const inactive = ref(true)
const hash = String(useRoute().params.hash)

async function activateAccount() {
    const loading = await loadingController.create({
        message: 'Ativando sua conta...',
        duration: 10000,
    })
    await loading.present()
    ApiRouter.user.activateAccount(hash).then(() => {
        inactive.value = false
    }).catch(() => {
        const okAlert = new MfpOkAlert('Ocorreu um erro!')
        okAlert.open('Não foi possível ativar sua conta. Tente novamente mais tarde.')
    })
    await loading.dismiss()
}
</script>

<template>
    <mfp-page>
        <div v-if="inactive" class="center-container">
            <ion-grid>
                <ion-row>
                    <ion-col size="1"/>
                    <ion-col size="10" class="ion-text-center">
                        <ion-text color="primary">
                            <h1>Ativação de Conta</h1>
                        </ion-text>
                        <ion-text>
                            <p>
                                Para ativar a sua conta e ter acesso ao App, basta clivar no botão abaixo.
                            </p>
                        </ion-text>
                        <ion-button id="open-loading" @click="activateAccount">
                            Ativar Conta
                        </ion-button>
                    </ion-col>
                    <ion-col size="1"/>
                </ion-row>
            </ion-grid>
        </div>
        <div v-else class="center-container">
            <ion-grid>
                <ion-row>
                    <ion-col size="1"/>
                    <ion-col size="10">
                        <ion-icon :icon="checkmarkCircleOutline" class="icon"/>
                    </ion-col>
                    <ion-col size="1"/>
                </ion-row>
                <ion-row class="ion-padding-bottom">
                    <ion-col size="1"/>
                    <ion-col size="10">
                        <ion-text color="primary">
                            <h1>Conta ativada!</h1>
                        </ion-text>
                        <ion-text>
                            <p>Sua conta foi ativada com sucesso. Agora você já pode fazer o login &#128515;</p>
                        </ion-text>
                        <ion-button routerLink="/v2/login" expand="block" class="ion-padding-top">
                            Fazer Login
                        </ion-button>
                    </ion-col>
                    <ion-col size="1"/>
                </ion-row>
            </ion-grid>
        </div>
    </mfp-page>
</template>

<style scoped>
.center-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 80vh;
}

.icon {
    width: 100%;
    font-size: 200px;
    color: var(--ion-color-success);
}
</style>
