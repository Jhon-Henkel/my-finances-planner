<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow} from '@ionic/vue'
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {arrowDownCircleOutline, arrowUpCircleOutline} from "ionicons/icons"
import router from "../../../../infra/router"

defineProps({
    incomes: {
        type: Number,
        required: true
    },
    expenses: {
        type: Number,
        required: true
    }
})
</script>

<template>
    <ion-row>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light" @click="router.push({name: 'movements'})">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="arrowUpCircleOutline" size="large" color="success"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Recebido</ion-card-subtitle>
                        <mfp-counter-money :end="incomes"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light" @click="router.push({name: 'movements'})">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="arrowDownCircleOutline" size="large" color="danger"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Pago</ion-card-subtitle>
                        <mfp-counter-money :end="expenses"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
