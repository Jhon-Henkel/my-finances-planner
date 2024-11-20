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
import {onMounted} from "vue"
import MfpEmptyListItem from "@/modules/@shared/components/list/MfpEmptyListItem.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpMovementsListSkeletonLoad from "@/views/movement/MfpMovementsListSkeletonLoad.vue"
import MfpMovementsListItem from "@/views/movement/MfpMovementsListItem.vue"
import MfpMovementsDetailsCard from "@/views/movement/MfpMovementsDetailsCard.vue"
import MfpMovementsFormModal from "@/views/movement/MfpMovementsFormModal.vue"
import MfpMovementsFilterModal from "@/views/movement/MfpMovementsFilterModal.vue"
import MfpMovementsFilterPeriodLabel from "@/views/movement/MfpMovementsFilterPeriodLabel.vue"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {MovementService} from "@/services/movement/MovementService"
import {MovementModel} from "@/model/movement/MovementModel"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import {useMovementStore} from "@/stores/movement/MovementStore"
import MfpFilterButton from "@/modules/@shared/components/button/MfpFilterButton.vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import {WalletService} from "@/services/wallet/WalletService"
import MfpTotalRegistersRow from "@/modules/@shared/components/page/MfpTotalRegistersRow.vue"

const formModal = new MfpModal(MfpMovementsFormModal)
const filterModal = new MfpModal(MfpMovementsFilterModal)
const movementStore = useMovementStore()

function filterMovement(event: any) {
    const query = event.target.value
    movementStore.filterMovementsOnStore(query)
}

async function optionsAction(movement: MovementModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtons(true, true, true))
    const action = await actionSheet.open()
    if (action === 'edit') {
        await editMovement(movement)
    } else if (action === 'delete') {
        await deleteMovement(movement)
    }
}

async function editMovement(movement: MovementModel) {
    if (movement.type === MovementService.transferType) {
        const invalidActionAlert = new MfpOkAlert("Ação inválida!")
        await invalidActionAlert.open('Não é possível editar movimentação do tipo transferência!')
        return
    }
    await formModal.open({movement: movement})
}

async function deleteMovement(movement: MovementModel) {
    let message = `Deseja realmente excluir a movimentação '${movement.description}'? `
    message += 'O valor na conta referente a essa movimentação será atualizado!'
    const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar a movimentação?')
    const confirm = await deleteConfirmAlert.open(message)
    if (confirm) {
        if (movement.type === MovementService.transferType) {
            await MovementService.deleteTransfer(movement.id)
        } else {
            await MovementService.delete(movement.id)
        }
        const toast = new MfpToast()
        await toast.open('Movimentação removida com sucesso!')
        await updateMovements()
        await WalletService.forceUpdateWalletList()
    }
}

async function updateMovements() {
    await MovementService.forceUpdateMovementList()
}

async function handleRefresh(event: any) {
    await updateMovements()
    event.target.complete()
}

onMounted(async () => {
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
        <mfp-movements-filter-period-label/>
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
        <mfp-total-registers-row :total-itens="movementStore.movements.length"/>
    </mfp-page>
</template>
