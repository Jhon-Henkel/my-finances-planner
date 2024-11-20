<script setup lang="ts">
import {IonCard, IonCardContent, IonCol, IonGrid, IonLabel, IonRow, IonText} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {useCardInvoicesStore} from "@/modules/credit-cards/store/CardInvoiceStore"

const store = useCardInvoicesStore()

function sumMonthValue(): number {
    let total = 0
    if (store.installmentSelected === 1) {
        store.invoice.forEach((item) => {
            total = total + item.firstInstallment
        })
    } else if (store.installmentSelected === 2) {
        store.invoice.forEach((item) => {
            total = total + item.secondInstallment
        })
    } else if (store.installmentSelected === 3) {
        store.invoice.forEach((item) => {
            total = total + item.thirdInstallment
        })
    } else if (store.installmentSelected === 4) {
        store.invoice.forEach((item) => {
            total = total + item.fourthInstallment
        })
    } else if (store.installmentSelected === 5) {
        store.invoice.forEach((item) => {
            total = total + item.fifthInstallment
        })
    } else if (store.installmentSelected === 6) {
        store.invoice.forEach((item) => {
            total = total + item.sixthInstallment
        })
    }
    return total
}
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
                            <mfp-counter-money :end="sumMonthValue()" class="ion-padding-start"/>
                        </ion-label>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-card-content>
    </ion-card>
</template>
