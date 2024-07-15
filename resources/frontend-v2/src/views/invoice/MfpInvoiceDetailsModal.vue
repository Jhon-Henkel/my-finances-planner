<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {IonCol, IonGrid, IonRow, modalController} from "@ionic/vue"
import {FutureExpenseModel} from "@/model/future-expense/FutureExpenseModel"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {UtilCalendar} from "@/util/UtilCalendar"
import {FutureProfitsModel} from "@/model/future-profits/FutureProfitsModel"

defineProps({
    item: {
        type: [FutureExpenseModel, FutureProfitsModel],
        required: true
    },
    totalLabel: {
        type: String,
        default: 'Total a Pagar'
    }
})

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header
        title="Detalhes"
        @close-action="closeModal"
        @save-action="closeModal"
        save-action-label="Ok"
    />
    <ion-grid>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Despesa: {{ item.description }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Valor:
                <mfp-counter-money :end="item.amount"/>
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Próxima Parcela: {{ UtilCalendar.formatStringToBr(item.forecast) }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Parcelas: {{ item.installments === 0 ? 'Despesa Fixa' : item.installments }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                {{ totalLabel }}:
                <mfp-counter-money :end="(item.amount * (item.installments === 0 ? 1 : item.installments))"/>
            </ion-col>
        </ion-row>
    </ion-grid>
</template>