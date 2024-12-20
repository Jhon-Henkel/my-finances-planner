<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {IonButton, IonCol, IonGrid, IonIcon, IonRow, IonText, loadingController} from "@ionic/vue"
import {onMounted, ref} from "vue"
import {useRoute} from "vue-router"
import {checkmarkCircleOutline} from "ionicons/icons"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import {RouteName} from "@/infra/router/routeName"
import router from "@/infra/router"

const inactive = ref(true)
const hash = String(useRoute().params.hash)
const seconds = ref(10)

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
        okAlert.open('Não foi possível ativar sua conta. Tente novamente mais tarde ou entre em contato via e-mail contato@financasnamao.com.br')
    })
    await loading.dismiss()
    const interval = setInterval(() => {
        if (seconds.value > 0) {
            seconds.value--;
        } else {
            clearInterval(interval);
        }
    }, 1000);
    setTimeout(() => {
        router.push({name: RouteName.login})
    }, 10000)
}

onMounted(() => {
    activateAccount()
})
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
                                Estamos ativando sua conta no finanças na mão, caso não aconteça automaticamente, você
                                pode clicar no botão "Ativar Conta" abaixo.
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
                            <p>Redirecionando para o login em <strong>{{ seconds }} segundos</strong>...</p>
                        </ion-text>
                        <ion-button routerLink="/v2/login" expand="block">
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
