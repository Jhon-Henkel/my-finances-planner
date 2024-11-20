<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import {
    IonIcon,
    IonItemOption,
    IonItemOptions,
    IonItemSliding,
    IonLabel,
    IonList,
    IonListHeader,
    IonButton
} from "@ionic/vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpPanoramaDetailsCard from "@/modules/panorama/component/MfpPanoramaDetailsCard.vue"
import MfpEmptyListItem from "@/modules/@shared/components/list/MfpEmptyListItem.vue"
import MfpTotalRegistersRow from "@/modules/@shared/components/page/MfpTotalRegistersRow.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {InvoiceModel} from "@/modules/invoice/model/invoiceModel"
import {onMounted, ref} from "vue"
import {usePanoramaStore} from "@/modules/panorama/store/PanoramaStore"
import {PanoramaService} from "@/modules/panorama/service/PanoramaService"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpPanoramaFormModal from "@/modules/panorama/component/MfpPanoramaFormModal.vue"
import {FutureExpenseService} from "@/modules/future-expense/service/FutureExpenseService"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import MfpPanoramaPayModal from "@/modules/panorama/component/MfpPanoramaPayModal.vue"
import MfpPanoramaAddValueModal from "@/modules/panorama/component/MfpPanoramaAddValueModal.vue"
import MfpPeriodSwitcher from "@/modules/@shared/components/switcher/MfpPeriodSwitcher.vue"
import MfpInvoiceListItem from "@/modules/invoice/component/MfpInvoiceListItem.vue"
import MfpInvoiceListSkeletonLoad from "@/modules/invoice/component/MfpInvoiceListSkeletonLoad.vue"
import MfpInvoiceDetailsModal from "@/modules/invoice/component/MfpInvoiceDetailsModal.vue"
import {InvoiceService} from "@/modules/invoice/service/InvoiceService"

const store = usePanoramaStore()
const formModal = new MfpModal(MfpPanoramaFormModal)
const okAlert = new MfpOkAlert('Ação inválida!')
const onlyNonPaid = ref(true)

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
        if (store.installmentSelected !== InvoiceService.getNumberOfNextInvoice(item)) {
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
        const details = new MfpModal(MfpInvoiceDetailsModal)
        await details.open({item: futureExpense})
    }
}

async function handleRefresh(event: any) {
    await PanoramaService.forceReloadStore()
    event.target.complete()
}

function mustShowItem(item: InvoiceModel, onlyNonPaid: boolean): boolean {
    return ! onlyNonPaid || (onlyNonPaid && InvoiceService.getInvoiceValueByNumber(store.installmentSelected, item) > 0)
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
        <div class="ion-text-end">
            <ion-button fill="clear" @click="onlyNonPaid = !onlyNonPaid">
                {{ onlyNonPaid ? 'Ver Todas' : 'Ver somente a pagar' }}
            </ion-button>
        </div>
        <mfp-empty-list-item :nothing-to-show="store.panorama.futureExpenses.length === 0 && store.isLoaded"/>
        <mfp-invoice-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding
                v-for="(item, index) in store.panorama.futureExpenses"
                :key="index"
                v-show="mustShowItem(item, onlyNonPaid)"
            >
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
