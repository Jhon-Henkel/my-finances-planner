<script setup lang="ts">
import {IonButton, IonText} from "@ionic/vue"
import MfpMainText from "@/modules/welcome/MfpMainText.vue"
import router from "../../infra/router"
import {MainSettingsService} from "@/modules/setings/service/MainSettingsService"
import {MainSettingsModel} from "@/modules/setings/model/MainSettingsModel"
import MfpRow from "@/modules/@shared/components/row/MfpRow.vue"

function goToDashboard() {
    const config = {
        name: 'must_show_welcome_page',
        value: '0'
    }
    MainSettingsService.update([new MainSettingsModel(config)])
    router.push({name: 'dashboard'})
}
</script>

<template>
    <mfp-row col-class="text-welcome">
        <ion-text color="primary">
            <h1><strong>Pronto, vamos combinar uma coisa?</strong></h1>
        </ion-text>
    </mfp-row>
    <mfp-row col-class="ion-margin-top ion-margin-bottom">
        <ion-text>
            Tudo que você cadastrar deve ser considerado as parcelas faltantes, então se você
            faz uma compra em 10 vezes e já pagou duas parcelas, não precisa cadastrar 10 parcelas, e sim 8, ok?
        </ion-text>
    </mfp-row>
    <mfp-row col-class="ion-margin-bottom">
        <ion-text>
            Para uma melhor experiência mobile via navegador, adicione o aplicativo à sua tela inicial. Assim você terá
            acesso mais rápido e fácil. Para isso, clique no botão de compartilhamento do seu navegador e selecione a
            opção "Adicionar à tela inicial".
        </ion-text>
    </mfp-row>
    <mfp-main-text/>
    <mfp-row col-class="ion-margin-bottom">
        <ion-button expand="block" @click="goToDashboard">
            Bora lá!
        </ion-button>
    </mfp-row>
</template>

<style scoped>
.text-welcome {
    margin-top: 50px;
    margin-bottom: 20px;
}
</style>
