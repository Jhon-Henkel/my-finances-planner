<script setup lang="ts">
import {
    IonIcon,
    IonItemOption,
    IonItemOptions,
    IonItemSliding,
    IonLabel,
    IonList,
    IonListHeader,
    IonSearchbar
} from "@ionic/vue"
import {ellipsisHorizontal} from 'ionicons/icons'
import {onMounted, ref} from "vue"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import MfpPage from "@/components/page/MfpPage.vue"
import MfpMovementsListSkeletonLoad from "@/views/movement/MfpMovementsListSkeletonLoad.vue"
import MfpMovementsListItem from "@/views/movement/MfpMovementsListItem.vue"
import MfpMovementsDetailsCard from "@/views/movement/MfpMovementsDetailsCard.vue"
import MfpMovementsFormModal from "@/views/movement/MfpMovementsFormModal.vue"
import MfpMovementsFilterModal from "@/views/movement/MfpMovementsFilterModal.vue"
import MfpMovementsFilterPeriodLabel from "@/views/movement/MfpMovementsFilterPeriodLabel.vue"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/components/toast/MfpToast"
import {UtilCalendar} from "@/util/UtilCalendar"
import {MovementService} from "@/services/movement/MovementService"
import {MovementModel} from "@/model/movement/MovementModel"
import {MfpModal} from "@/components/modal/MfpModal"
import {useMovementStore} from "@/stores/movement/MovementStore"
import MfpFilterButton from "@/components/button/MfpFilterButton.vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"

const movements = ref<MovementModel[]>([])
const originalMovements = ref<MovementModel[]>([])
const totalIncomes = ref(0)
const totalExpenses = ref(0)
const totalBalance = ref(0)
const movementToEditLocal = ref()
const filterPeriodLabel = ref('')
const formModal = new MfpModal(MfpMovementsFormModal)
const filterModal = new MfpModal(MfpMovementsFilterModal)
const movementStore = useMovementStore()

async function optionsAction(movement: MovementModel) {
    movementToEditLocal.value = movement
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtons(true, true, true))
    const action = await actionSheet.open()
    if (action === 'edit') {
        if (movementToEditLocal.value.type === MovementService.transferType) {
            const invalidActionAlert = new MfpOkAlert("Ação inválida!")
            await invalidActionAlert.open('Não é possível editar movimentação do tipo transferência!')
            return
        }
        await formModal.open({movement: movementToEditLocal.value})
    } else if (action === 'delete') {
        let message = `Deseja realmente excluir a movimentação ${movementToEditLocal.value.name}? `
        message += 'O valor na conta referente a essa movimentação será atualizada!'
        const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar a movimentação?')
        const confirm = await deleteConfirmAlert.open(message)
        if (confirm) {
            await MovementService.delete(movementToEditLocal.value.id)
            const toast = new MfpToast()
            await toast.open('Movimentação removida com sucesso!')
            await updateMovements()
        }
    }
}

function filterMovement(event: any) {
    const query = event.target.value.toLowerCase()
    movements.value = originalMovements.value
    if (!query) {
        return
    }
    movements.value = movements.value.filter(
        movement =>
            movement.description.toLowerCase().includes(query)
            || movement.walletName && movement.walletName.toLowerCase().includes(query)
    )
}

async function updateMovements(quest: null | string = null) {
    filterPeriodLabel.value = UtilCalendar.makeLabelFilterDate(quest)
    await MovementService.forceUpdateMovementList()
}

async function handleRefresh(event: any) {
    await updateMovements()
    event.target.complete()
}

onMounted(async () => {
    filterPeriodLabel.value = UtilCalendar.makeLabelFilterDate()
    await updateMovements()
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Movimentações</ion-label>
            <mfp-filter-button @click="filterModal.open()"/>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-movements-filter-period-label :filter-period-label="filterPeriodLabel"/>
        <mfp-movements-details-card/>
        <ion-searchbar :animated="true" placeholder="Buscar por conta ou descrição" @ionInput="filterMovement($event)"/>
        <mfp-empty-list-item :nothing-to-show="movementStore.movements.length === 0 && movementStore.isLoaded"/>
        <mfp-movements-list-skeleton-load :is-loaded="movementStore.isLoaded"/>
        <ion-list v-if="movementStore.isLoaded">
            <ion-item-sliding v-for="(movement, index) in movementStore.movements" :key="index" class="ion-text-center">
                <mfp-movements-list-item :movement="movement"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(movement)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
    </mfp-page>
</template>