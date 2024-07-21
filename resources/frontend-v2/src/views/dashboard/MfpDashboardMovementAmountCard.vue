<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow} from '@ionic/vue'
import {onMounted} from "vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {arrowDownCircleOutline, arrowUpCircleOutline} from "ionicons/icons"
import {useMovementStore} from "@/stores/movement/MovementStore"
import {MovementService} from "@/services/movement/MovementService"

const movementStore = useMovementStore()

onMounted(async () => {
    await MovementService.forceUpdateMovementList()
})
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
                        <ion-card-subtitle>Recebido</ion-card-subtitle>
                        <mfp-counter-money :end="movementStore.thisMonthTotalIncomesValue"/>
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
                        <ion-card-subtitle>Pago</ion-card-subtitle>
                        <mfp-counter-money :end="movementStore.thisMonthTotalExpensesValue"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>