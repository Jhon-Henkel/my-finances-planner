<script setup lang="ts">
import {IonCard, IonCardContent, IonCol, IonGrid, IonLabel, IonRow, IonText} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"

defineProps({
    store: {
        type: Object,
        required: true
    }
})

</script>

<template>
    <ion-card color="light" class="no-margin-top">
        <ion-card-content class="value">
            <ion-grid class="ion-no-padding">
                <ion-row>
                    <ion-col class="ion-text-center">
                        <ion-label class="center-ion-label-content">
                            <ion-text>
                                Total fatura:
                            </ion-text>
                            <mfp-counter-money :end="store.monthTotalAmount" class="ion-padding-start"/>
                        </ion-label>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-card-content>
    </ion-card>
</template>
