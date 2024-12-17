<script setup lang="ts">
import {IonBadge, IonCard, IonCardContent, IonCardSubtitle, IonCol, IonGrid, IonRow,} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"

defineProps(
    {
        store: {
            type: Object,
            required: true
        }
    }
)
</script>

<template>
    <ion-card color="light" class="no-margin-bottom no-margin-top">
        <ion-card-content class="value">
            <ion-grid class="ion-no-padding">
                <ion-row>
                    <ion-col class="ion-text-center">
                        <ion-card-subtitle>Total Previsto para o mês</ion-card-subtitle>
                        <ion-badge :color="store.monthTotalAmount >= 0 ? 'success' : 'danger'">
                            <mfp-counter-money :end="store.monthTotalAmount"/>
                        </ion-badge>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-card-content>
    </ion-card>
</template>
