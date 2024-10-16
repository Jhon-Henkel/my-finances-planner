<script setup lang="ts">
import {IonCard, IonCardContent, IonCol, IonGrid, IonRow, IonText} from "@ionic/vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"

defineProps(
    {
        balance: {
            type: Number,
            required: true
        }
    }
)
</script>

<template>
    <ion-card color="light">
        <ion-card-content class="value">
            <ion-grid class="ion-no-padding">
                <ion-row>
                    <ion-col class="ion-text-center balance-text">
                        <ion-text>Saldo total</ion-text>
                    </ion-col>
                </ion-row>
                <ion-row>
                    <ion-col class="ion-text-center balance-value">
                        <ion-text>
                            <strong>
                                <mfp-counter-money :end="balance"/>
                            </strong>
                        </ion-text>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-card-content>
    </ion-card>
</template>
