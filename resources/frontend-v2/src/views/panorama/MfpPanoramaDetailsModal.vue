<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {IonCol, IonGrid, IonRow, modalController} from "@ionic/vue"
import {FutureExpenseModel} from "@/model/future-expense/FutureExpenseModel"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {UtilCalendar} from "@/util/UtilCalendar"

defineProps({
    futureExpense: {
        type: FutureExpenseModel,
        required: true
    }
})

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header
        title="Adicionar Valor"
        @close-action="closeModal"
        @save-action="closeModal"
        save-action-label="Ok"
    />
    <ion-grid>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Despesa: {{ futureExpense.description }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Valor:
                <mfp-counter-money :end="futureExpense.amount"/>
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Próxima Parcela: {{ UtilCalendar.formatStringToBr(futureExpense.forecast) }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Parcelas: {{ futureExpense.installments === 0 ? 'Despesa Fixa' : futureExpense.installments }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Total a Pagar:
                <mfp-counter-money :end="(futureExpense.amount * (futureExpense.installments === 0 ? 1 : futureExpense.installments))"/>
            </ion-col>
        </ion-row>
    </ion-grid>
</template>