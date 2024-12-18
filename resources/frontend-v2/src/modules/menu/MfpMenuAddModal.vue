<script setup lang="ts">
import {IonCol, IonIcon, IonItem, IonLabel, IonModal, IonRow, modalController} from "@ionic/vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {calendarNumberOutline, cardOutline, cashOutline, swapHorizontalOutline} from "ionicons/icons"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpMovementsFormModal from "@/modules/movement/component/MfpMovementsFormModal.vue"
import MfpCardInvoicesFormModal from "@/modules/credit-cards/component/MfpCardInvoicesFormModal.vue"
import MfpEarningPlanFormModal from "@/modules/earning-plan/component/MfpEarningPlanFormModal.vue"
import MfpSpendingPlanFormModal from "@/modules/spending-plan/component/MfpSpendingPlanFormModal.vue"

const modalBreakpoints: Array<number> = [0, 0.85]
const movementFormModal = new MfpModal(MfpMovementsFormModal)
const panoramaFormModal = new MfpModal(MfpSpendingPlanFormModal)
const futureProfitFormModal = new MfpModal(MfpEarningPlanFormModal)
const cardInstallmentFormModal = new MfpModal(MfpCardInvoicesFormModal)

function openModal(modal: MfpModal) {
    modalController.dismiss()
    modal.open()
}
</script>

<template>
    <ion-modal
        trigger="mfp-tab-plus-modal"
        :initial-breakpoint="modalBreakpoints[1]"
        :breakpoints="modalBreakpoints"
        handle-behavior="cycle"
    >
        <ion-row class="ion-text-center ion-margin-top">
            <ion-col class="ion-margin-top">
                <ion-label>
                    Adicionar Novo:
                </ion-label>
            </ion-col>
        </ion-row>
        <mfp-modal-content>
            <template #list>
                <ion-item :button="true" @click="openModal(movementFormModal)">
                    <ion-icon slot="start" :icon="swapHorizontalOutline"/>
                    <ion-label>Movimentação</ion-label>
                </ion-item>
                <ion-item :button="true" @click="openModal(panoramaFormModal)">
                    <ion-icon slot="start" :icon="calendarNumberOutline"/>
                    <ion-label>Plano de Gasto</ion-label>
                </ion-item>
                <ion-item :button="true" @click="openModal(futureProfitFormModal)">
                    <ion-icon slot="start" :icon="cashOutline"/>
                    <ion-label>Plano de Receita</ion-label>
                </ion-item>
                <ion-item :button="true" @click="openModal(cardInstallmentFormModal)">
                    <ion-icon slot="start" :icon="cardOutline"/>
                    <ion-label>Parcela Cartão</ion-label>
                </ion-item>
            </template>
        </mfp-modal-content>
    </ion-modal>
</template>
