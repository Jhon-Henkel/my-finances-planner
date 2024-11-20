<script lang="ts" setup>
import {IonDatetime, IonDatetimeButton, IonItem, IonModal, IonText, modalController} from '@ionic/vue'
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import {useFinancialHealthStore} from "@/stores/financial-health/financialHealthStore"

const store = useFinancialHealthStore()

async function filter() {
    const dateFilterString = UtilCalendar.makeStringFilterDate(store.dateFilter)
    const quest = `${dateFilterString}&type=0&dontGroupCardExpenses=${store.groupCards}`
    store.monthSelected = UtilCalendar.makeDate(store.dateFilter).getMonth()
    store.load(quest)
    closeModal()
}

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Filtro" save-action-label="Filtrar" @close-action="closeModal" @save-action="filter"/>
    <mfp-modal-content>
        <template #list>
            <mfp-input-toggle label="Desagrupar Despesas Cartão" v-model="store.groupCards"/>
            <ion-item>
                <ion-text>Período</ion-text>
                <div class="date-filter-button">
                    <ion-datetime-button datetime="datetime"/>
                </div>
            </ion-item>
            <ion-modal :keep-contents-mounted="true">
                <ion-datetime
                    v-model="store.dateFilter"
                    presentation="month-year"
                    id="datetime"
                    :prefer-wheel="true"
                    :show-clear-button="true"
                    :show-default-buttons="true"
                    clear-text="Hoje"
                    done-text="Ok"
                    cancel-text="Fechar"
                />
            </ion-modal>
        </template>
    </mfp-modal-content>
</template>

<style scoped>
.date-filter-button {
    flex-grow: 1;
    justify-content: flex-end;
    display: flex;
}
</style>
