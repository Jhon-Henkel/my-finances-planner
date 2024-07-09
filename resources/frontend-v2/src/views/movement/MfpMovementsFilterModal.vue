<script lang="ts" setup>
import {
    IonButton,
    IonContent,
    IonDatetime,
    IonDatetimeButton,
    IonIcon,
    IonItem,
    IonList,
    IonModal,
    IonText
} from '@ionic/vue'
import {ref} from "vue"
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {UtilCalendar} from "@/util/UtilCalendar"
import {MovementService} from "@/services/movement/MovementService"
import MfpMovementsTypeSelect from "@/components/select/MfpMovementsTypeSelect.vue"
import {filterCircleOutline} from "ionicons/icons"

const emits = defineEmits(['filterChanged'])
const typeFilter = ref(MovementService.allType)
const dateFilter = ref(UtilCalendar.getTodayIso())
const modal = ref()

function sendFilter() {
    const dateFilterString = UtilCalendar.makeStringFilterDate(dateFilter.value)
    const filter = `type=${typeFilter.value}&${dateFilterString}`
    emits('filterChanged', filter)
    closeModal()
}

function closeModal() {
    modal.value.$el.dismiss()
}
</script>

<template>
    <ion-button class="ion-no-padding" id="mfp-filter-modal" expand="block">
        <ion-icon :icon="filterCircleOutline" class="top-icon"/>
    </ion-button>
    <ion-modal
        trigger="mfp-filter-modal"
        :initial-breakpoint="0.65"
        :breakpoints="[0, 0.65, 0.85]"
        handle-behavior="cycle"
        ref="modal"
    >
        <mfp-modal-header
            title="Filtro"
            save-action-label="Filtrar"
            @close-action="closeModal"
            @save-action="sendFilter"
        />
        <ion-content class="ion-padding">
            <ion-list :inset="true">
                <mfp-movements-type-select v-model="typeFilter" label="Tipo:" :forFilter="true"/>
                <ion-item>
                    <ion-text>Período:</ion-text>
                    <ion-datetime-button datetime="datetime" class="full-width ion-justify-content-end"/>
                </ion-item>
            </ion-list>
            <ion-modal :keep-contents-mounted="true">
                <ion-datetime v-model="dateFilter" presentation="month-year" id="datetime" :prefer-wheel="true"/>
            </ion-modal>
        </ion-content>
    </ion-modal>
</template>

<style scoped>
.top-icon {
    font-size: 1.8em;
}
</style>