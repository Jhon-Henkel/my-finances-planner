<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {IonCol, IonGrid, IonRow, modalController} from "@ionic/vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {CardModel} from "@/modules/credit-cards/model/CardModel"

defineProps({
    item: {
        type: CardModel,
        required: true
    }
})

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Detalhes" @close-action="closeModal" @save-action="closeModal" save-action-label="Ok"/>
    <ion-grid>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Cartão: {{ item.name }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Próxima Fatura:
                <mfp-counter-money :end="item.nextInvoiceValue"/>
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Limite Total:
                <mfp-counter-money :end="item.limit"/>
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Limite Restante:
                <mfp-counter-money :end="item.limit - item.totalValueSpending"/>
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Fecha Dia: {{ item.closingDay }}
            </ion-col>
        </ion-row>
        <ion-row class="ion-margin-top">
            <ion-col class="ion-text-center">
                Vence Dia: {{ item.dueDate }}
            </ion-col>
        </ion-row>
    </ion-grid>
</template>
