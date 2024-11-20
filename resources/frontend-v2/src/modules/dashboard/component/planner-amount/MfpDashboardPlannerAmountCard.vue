<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow} from '@ionic/vue'
import {onMounted} from "vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {calendarNumberOutline, cashOutline} from "ionicons/icons"
import {usePanoramaStore} from "@/modules/panorama/store/PanoramaStore"
import router from "../../../../infra/router"

const panoramaStore = usePanoramaStore()

onMounted(async () => {
    if (!panoramaStore.isLoaded) {
        await panoramaStore.load()
    }
})
</script>

<template>
    <ion-row>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light" @click="router.push({name: 'future-profits'})">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="cashOutline" size="large" color="success"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Receber</ion-card-subtitle>
                        <mfp-counter-money :end="panoramaStore?.panorama?.totalFutureGains?.firstInstallment ?? 0"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light" @click="router.push({name: 'panorama'})">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="calendarNumberOutline" size="large" color="danger"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Pagar</ion-card-subtitle>
                        <mfp-counter-money :end="(panoramaStore?.panorama?.totalFutureExpenses?.firstInstallment ?? 0) + (panoramaStore?.panorama?.totalCreditCardExpenses?.firstInstallment ?? 0)"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
