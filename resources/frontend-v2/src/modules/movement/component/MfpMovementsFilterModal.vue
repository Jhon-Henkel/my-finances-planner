<script lang="ts" setup>
import {modalController} from '@ionic/vue'
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpMovementsTypeSelect from "@/modules/@shared/components/select/MfpMovementsTypeSelect.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {useMovementStore} from "@/modules/movement/store/MovementStore"

const store = useMovementStore()

async function filter() {
    const filter = `type=${store.lastMovementFilterType}`
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
        </template>
    </mfp-modal-content>
</template>
