<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {IonCol, IonGrid, IonRow, modalController} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {EarningPlanModel} from "@/modules/earning-plan/model/EarningPlanModel"
import {SpendingPlanModel} from "@/modules/spending-plan/model/SpendingPlanModel"

defineProps({
    item: {
        type: [EarningPlanModel, SpendingPlanModel],
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
