<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {eyeOffOutline, eyeOutline} from "ionicons/icons"

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
    <ion-row>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="eyeOutline" size="large" color="success"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Visível</ion-card-subtitle>
                        <mfp-counter-money :end="store.totalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="eyeOffOutline" size="large" color="danger"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Oculto</ion-card-subtitle>
                        <mfp-counter-money :end="store.totalAmountHidden"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
    <ion-row>
        <ion-col size="12">
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin">
                    <ion-col size="12" class="ion-text-center">
                        <ion-card-subtitle>Total</ion-card-subtitle>
                        <mfp-counter-money :end="(store.totalAmount + store.totalAmountHidden)"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
