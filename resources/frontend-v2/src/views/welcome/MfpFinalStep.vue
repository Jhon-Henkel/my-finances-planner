<script setup lang="ts">
import {IonButton, IonCol, IonRow, IonText} from "@ionic/vue"
import MfpMainText from "@/views/welcome/MfpMainText.vue"
import router from "@/router"
import {MainSettingsService} from "@/services/Settings/MainSettingsService"
import {MainSettingsModel} from "@/model/settings/MainSettingsModel"

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
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="text-welcome">
            <ion-text color="primary">
                <h1>
                    <strong>
                        Tudo Pronto!
                    </strong>
                </h1>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
    <mfp-main-text/>
    <ion-row class="ion-margin-top">
        <ion-col size="1"/>
        <ion-col size="10">
            <ion-button expand="block" @click="goToDashboard">
                Bora lá!
            </ion-button>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>

<style scoped>
.text-welcome {
    margin-top: 50px;
    margin-bottom: 20px;
}
</style>
