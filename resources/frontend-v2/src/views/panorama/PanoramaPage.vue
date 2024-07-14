<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"
import MfpPanoramaDetailsCard from "@/views/panorama/MfpPanoramaDetailsCard.vue"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import MfpTotalRegistersRow from "@/components/page/MfpTotalRegistersRow.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import {InvoiceModel} from "@/model/invoice/invoiceModel"
import {onMounted} from "vue"
import {usePanoramaStore} from "@/stores/panorama/PanoramaStore"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpPanoramaFormModal from "@/views/panorama/MfpPanoramaFormModal.vue"
import {FutureExpenseService} from "@/services/future-expense/FutureExpenseService"
import {UtilCalendar} from "@/util/UtilCalendar"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import MfpPanoramaPayModal from "@/views/panorama/MfpPanoramaPayModal.vue"
import MfpPanoramaAddValueModal from "@/views/panorama/MfpPanoramaAddValueModal.vue"
import MfpPanoramaDetailsModal from "@/views/panorama/MfpPanoramaDetailsModal.vue"
import MfpPeriodSwitcher from "@/components/switcher/MfpPeriodSwitcher.vue"
import MfpInvoiceListItem from "@/views/invoice/MfpInvoiceListItem.vue"
import MfpInvoiceListSkeletonLoad from "@/views/invoice/MfpInvoiceListSkeletonLoad.vue"

const store = usePanoramaStore()
const formModal = new MfpModal(MfpPanoramaFormModal)
const okAlert = new MfpOkAlert('Ação inválida!')

async function optionsAction(item: InvoiceModel) {
    if (item.id == 0 && item.countId == 0) {
        let message = 'Essa despesa é apenas do tipo informativa, não é possível fazer nenhuma ação com ela. '
        message += 'Conforme for marcando movimentações com esse nome o valor será atualizado automaticamente.'
        await okAlert.open(message)
        return
    }
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToPanorama())
    const action = await actionSheet.open()
    if (action === 'edit') {
        const futureExpense = await FutureExpenseService.get(item.id)
        futureExpense.forecast = UtilCalendar.toIso(futureExpense.forecast)
        await formModal.open({futureExpense: futureExpense})
    } else if (action === 'delete') {
        await FutureExpenseService.delete(item)
    } else if (action === 'pay') {
        if (store.installmentSelected !== PanoramaService.getNumberOfNextInvoice(item)) {
            await okAlert.open('Essa não é a próxima parcela a ser paga!')
            return
        }
        const payModal = new MfpModal(MfpPanoramaPayModal)
        await payModal.open({item: item})
    } else if (action === 'add-value') {
        const futureExpense = await FutureExpenseService.get(item.id)
        const addValueModal = new MfpModal(MfpPanoramaAddValueModal)
        await addValueModal.open({futureExpense: futureExpense})
    } else if (action === 'details') {
        const futureExpense = await FutureExpenseService.get(item.id)
        const details = new MfpModal(MfpPanoramaDetailsModal)
        await details.open({futureExpense: futureExpense})
    }
}

async function handleRefresh(event: any) {
    await PanoramaService.forceReloadStore()
    event.target.complete()
}

onMounted(async () => {
    if (!store.isLoaded) {
        await store.load()
    }
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Plano de Gastos</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-period-switcher :store="store"/>
        <mfp-panorama-details-card/>
        <mfp-empty-list-item :nothing-to-show="store.panorama.futureExpenses.length === 0 && store.isLoaded"/>
        <mfp-invoice-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding v-for="(item, index) in store.panorama.futureExpenses" :key="index">
                <mfp-invoice-list-item :invoice-item="item" :store="store"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="store.panorama.futureExpenses.length"/>
    </mfp-page>
</template>
