<script setup lang="ts">
import {
    IonBadge,
    IonCard,
    IonCardContent,
    IonCardSubtitle,
    IonCol,
    IonGrid,
    IonRow,
} from "@ionic/vue"
import {useFutureProfitsStore} from "@/stores/future-profits/FutureProfitsStore"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"

const store = useFutureProfitsStore()

function sumMonthValue(): number {
    let total = 0
    if (store.installmentSelected === 1) {
        store.futureProfits.forEach((item) => {
            total = total + item.firstInstallment
        })
    } else if (store.installmentSelected === 2) {
        store.futureProfits.forEach((item) => {
            total = total + item.secondInstallment
        })
    } else if (store.installmentSelected === 3) {
        store.futureProfits.forEach((item) => {
            total = total + item.thirdInstallment
        })
    } else if (store.installmentSelected === 4) {
        store.futureProfits.forEach((item) => {
            total = total + item.fourthInstallment
        })
    } else if (store.installmentSelected === 5) {
        store.futureProfits.forEach((item) => {
            total = total + item.fifthInstallment
        })
    } else if (store.installmentSelected === 6) {
        store.futureProfits.forEach((item) => {
            total = total + item.sixthInstallment
        })
    }
    return total
}
</script>

<template>
    <ion-card color="light" class="no-margin-bottom no-margin-top">
        <ion-card-content class="value">
            <ion-grid class="ion-no-padding">
                <ion-row>
                    <ion-col class="ion-text-center">
                            <ion-card-subtitle>Total Previsto para o mês</ion-card-subtitle>
                            <ion-badge :color="sumMonthValue() >= 0 ? 'success' : 'danger'">
                                <mfp-counter-money :end="sumMonthValue()"/>
                            </ion-badge>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-card-content>
    </ion-card>
</template>
