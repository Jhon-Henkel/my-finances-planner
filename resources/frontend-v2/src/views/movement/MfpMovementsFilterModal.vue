<script lang="ts" setup>
import {IonDatetime, IonDatetimeButton, IonItem, IonModal, IonText, modalController} from '@ionic/vue'
import {ref} from "vue"
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {UtilCalendar} from "@/util/UtilCalendar"
import MfpMovementsTypeSelect from "@/components/select/MfpMovementsTypeSelect.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {useMovementStore} from "@/stores/movement/MovementStore"

const store = useMovementStore()
const dateFilter = ref(UtilCalendar.getTodayIso())

async function filter() {
    const dateFilterString = UtilCalendar.makeStringFilterDate(dateFilter.value)
    const filter = `type=${store.lastMovementFilterType}&${dateFilterString}`
    store.loadAgainOnNextTick()
    await store.loadMovements(filter)
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
            <mfp-movements-type-select label="Tipo:" :forFilter="true"/>
            <ion-item>
                <ion-text>Período:</ion-text>
                <div class="date-filter-button">
                    <ion-datetime-button datetime="datetime"/>
                </div>
            </ion-item>
            <ion-modal :keep-contents-mounted="true">
                <ion-datetime
                    v-model="dateFilter"
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
