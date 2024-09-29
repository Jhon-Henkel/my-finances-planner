<script setup lang="ts">
import {IonButton, IonCol, IonRow, IonText} from "@ionic/vue"
import MfpMainText from "@/views/welcome/MfpMainText.vue"
import router from "@/router"
import {MainSettingsService} from "@/services/Settings/MainSettingsService"
import {MainSettingsModel} from "@/model/settings/MainSettingsModel"
import MfpRow from "@/components/row/MfpRow.vue"

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
            <h1><strong>Tudo Pronto!</strong></h1>
        </ion-text>
    </mfp-row>
    <mfp-row col-class="ion-margin-top ion-margin-bottom">
        <ion-text>
            Vamos combinar uma coisa? tudo que você cadastrar deve ser considerado as parcelas faltantes, então se você
            faz uma compra em 10 vezes e ja pagou duas parcelas, não precisa cadastrar 10 parcelas, e sim 8, ok?
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
