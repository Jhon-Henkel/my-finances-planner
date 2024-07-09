<script setup lang="ts">
import {IonCard, IonCardContent, IonCol, IonGrid, IonIcon, IonLabel, IonRow, IonText} from "@ionic/vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {arrowDownOutline, arrowUpOutline, walletOutline} from "ionicons/icons"

defineProps(
    {
        incomes: {
            type: Number,
            required: true
        },
        expenses: {
            type: Number,
            required: true
        },
        balance: {
            type: Number,
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
                    <ion-col size="6">
                        <ion-label class="center-ion-label-content">
                            <ion-icon :icon="arrowUpOutline" color="success" class="icon"/>
                            <ion-text>
                                <mfp-counter-money :end="incomes"/>
                            </ion-text>
                        </ion-label>
                    </ion-col>
                    <ion-col size="6">
                        <ion-label class="center-ion-label-content">
                            <ion-icon :icon="arrowDownOutline" color="danger" class="icon"/>
                            <ion-text>
                                <mfp-counter-money :end="expenses"/>
                            </ion-text>
                        </ion-label>
                    </ion-col>
                </ion-row>
                <ion-row class="ion-margin-top">
                    <ion-col>
                        <ion-label class="center-ion-label-content">
                            <ion-icon :icon="walletOutline" color="primary" class="icon"/>
                            <ion-text>
                                <mfp-counter-money :end="balance"/>
                            </ion-text>
                        </ion-label>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-card-content>
    </ion-card>
</template>

<style scoped>
.icon {
    font-size: 1.5em;
    margin-right: 10px;
}
</style>