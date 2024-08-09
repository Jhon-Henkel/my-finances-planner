<script setup lang="ts">
import {IonBadge, IonCard, IonCardSubtitle, IonCol, IonRow} from '@ionic/vue'
import {onMounted} from "vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {useMovementStore} from "@/stores/movement/MovementStore"

const movementStore = useMovementStore()

onMounted(async () => {
    if (!movementStore.isLoaded) {
        await movementStore.loadMovements()
    }
})
</script>

<template>
    <ion-row>
        <ion-col>
            <ion-card color="light" class="ion-no-margin ion-text-center">
                <ion-row class="ion-margin">
                    <ion-col size="12">
                        <ion-card-subtitle>Balanço do mês</ion-card-subtitle>
                        <ion-badge :color="movementStore.thisMonthTotalBalance > 0 ? 'success' : 'danger'">
                            <mfp-counter-money :end="movementStore.thisMonthTotalBalance"/>
                        </ion-badge>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
