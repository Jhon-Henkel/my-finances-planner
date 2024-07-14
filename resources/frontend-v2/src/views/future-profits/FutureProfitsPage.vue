<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import {useFutureProfitsStore} from "@/stores/future-profits/FutureProfitsStore"
import {onMounted} from "vue"
import MfpPeriodSwitcher from "@/components/switcher/MfpPeriodSwitcher.vue"
import MfpTotalRegistersRow from "@/components/page/MfpTotalRegistersRow.vue"
import MfpFutureProfitsDetailsCard from "@/views/future-profits/MfpFutureProfitsDetailsCard.vue"
import {FutureProfitsService} from "@/services/future-profits/FutureProfitsService"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import MfpInvoiceListItem from "@/views/invoice/MfpInvoiceListItem.vue"
import MfpInvoiceListSkeletonLoad from "@/views/invoice/MfpInvoiceListSkeletonLoad.vue"
import {MfpModal} from "@/components/modal/MfpModal"
import {IInvoice} from "@/services/invoice/IInvoice"
import MfpFutureProfitsFormModal from "@/views/future-profits/MfpFutureProfitsFormModal.vue"
import {UtilCalendar} from "@/util/UtilCalendar"
import MfpInvoiceDetailsModal from "@/views/invoice/MfpInvoiceDetailsModal.vue"
import {InvoiceService} from "@/services/invoice/InvoiceService"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import MfpFutureProfitsReceiveModal from "@/views/future-profits/MfpFutureProfitsReceiveModal.vue"

const store = useFutureProfitsStore()
const formModal = new MfpModal(MfpFutureProfitsFormModal)
const okAlert = new MfpOkAlert('Ação inválida!')

async function optionsAction(item: IInvoice) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToFutureProfits())
    const action = await actionSheet.open()
    if (action === 'edit') {
        const futureProfit = await FutureProfitsService.get(item.id)
        futureProfit.forecast = UtilCalendar.toIso(futureProfit.forecast)
        await formModal.open({futureProfit: futureProfit})
    } else if (action === 'delete') {
        await FutureProfitsService.delete(item)
    } else if (action === 'receive') {
        if (store.installmentSelected !== InvoiceService.getNumberOfNextInvoice(item)) {
            await okAlert.open('Essa não é a próxima parcela a receber!')
            return
        }
        const receiveModal = new MfpModal(MfpFutureProfitsReceiveModal)
        await receiveModal.open({item: item})
    } else if (action === 'details') {
        const futureProfit = await FutureProfitsService.get(item.id)
        const details = new MfpModal(MfpInvoiceDetailsModal)
        await details.open({item: futureProfit, totalLabel: 'Total a Receber'})
    }
}

async function handleRefresh(event: any) {
    await FutureProfitsService.forceLoadStore()
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
            <ion-label>Plano de Receitas</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-period-switcher :store="store"/>
        <mfp-future-profits-details-card/>
        <mfp-empty-list-item :nothing-to-show="store.futureProfits.length === 0 && store.isLoaded"/>
        <mfp-invoice-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding v-for="(item, index) in store.futureProfits" :key="index">
                <mfp-invoice-list-item :store="store" :invoice-item="item"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="store.futureProfits.length"/>
    </mfp-page>
</template>
