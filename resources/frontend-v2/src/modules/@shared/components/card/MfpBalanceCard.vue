<script setup lang="ts">
import router from "@/infra/router"
import {IonBadge, IonCard, IonCardSubtitle, IonCol, IonRow} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"

const props = defineProps({
    balance: {
        type: Number,
        required: true
    },
    redirectToMovements: {
        type: Boolean,
        default: true
    }
})

function redirectToMovement() {
    if (props.redirectToMovements) {
        router.push({name: 'movements'})
    }
}
</script>

<template>
    <ion-row>
        <ion-col>
            <ion-card color="light" class="ion-no-margin ion-text-center" @click="redirectToMovement">
                <ion-row class="ion-margin">
                    <ion-col size="12">
                        <ion-card-subtitle>Balanço do mês</ion-card-subtitle>
                        <ion-badge :color="balance > 0 ? 'success' : 'danger'">
                            <mfp-counter-money :end="balance"/>
                        </ion-badge>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
