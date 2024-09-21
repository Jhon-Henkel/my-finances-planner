<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow} from '@ionic/vue'
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {arrowDownCircleOutline, arrowUpCircleOutline} from "ionicons/icons"
import {useFinancialHealthStore} from "@/stores/financial-health/financialHealthStore"

const store = useFinancialHealthStore()
</script>

<template>
    <ion-row>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="arrowUpCircleOutline" size="large" color="success"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Recebeu</ion-card-subtitle>
                        <mfp-counter-money :end="store.items.incomeTotalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="arrowDownCircleOutline" size="large" color="danger"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Gastou</ion-card-subtitle>
                        <mfp-counter-money :end="store.items.expenseTotalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
