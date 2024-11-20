<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonRow, IonList, IonButton} from '@ionic/vue'
import MfpDashboardLastMovementItem from "@/modules/dashboard/component/last-movements/MfpDashboardLastMovementItem.vue"
import router from "../../../../infra/router"
import {onMounted} from "vue"
import {useMovementStore} from "@/stores/movement/MovementStore"
import MfpDashboardLastMovementItemSkeletonLoad from "@/modules/dashboard/component/last-movements/MfpDashboardLastMovementItemSkeletonLoad.vue"

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
                <ion-row class="ion-margin-top">
                    <ion-col size="12">
                        <ion-card-subtitle>Últimas Movimentações</ion-card-subtitle>
                        <ion-list :inset="true" class="margin">
                            <mfp-dashboard-last-movement-item v-if="movementStore.isLoaded"/>
                            <mfp-dashboard-last-movement-item-skeleton-load v-else/>
                        </ion-list>
                    </ion-col>
                </ion-row>
                <ion-row class="ion-no-margin">
                    <ion-col class="ion-no-padding">
                        <ion-button
                            fill="clear"
                            @click="router.push({name: 'movements'})"
                            class="ion-no-padding ion-no-margin"
                        >
                            Ver todas
                        </ion-button>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>

<style scoped>
.margin {
    margin-left: 0 !important;
    margin-right: 0 !important;
    margin-bottom: 0 !important;
}
</style>
