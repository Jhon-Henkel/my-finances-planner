<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonRow} from '@ionic/vue'
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {useFinancialHealthStore} from "@/stores/financial-health/financialHealthStore"

const store = useFinancialHealthStore()
</script>

<template>
    <ion-row>
        <ion-col>
            <ion-card color="light" class="ion-no-margin ion-text-center">
                <ion-row class="ion-margin">
                    <ion-col size="12">
                        <ion-card-subtitle>Balanço do Mês</ion-card-subtitle>
                        <mfp-counter-money :end="store.items.incomeTotalAmount - store.items.expenseTotalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
