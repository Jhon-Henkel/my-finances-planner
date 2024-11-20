<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {onMounted, ref} from "vue"
import {useRoute} from "vue-router"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import MfpPeriodSwitcher from "@/modules/@shared/components/switcher/MfpPeriodSwitcher.vue"
import {useCardInvoicesStore} from "@/modules/credit-cards/store/CardInvoiceStore"
import MfpEmptyListItem from "@/modules/@shared/components/list/MfpEmptyListItem.vue"
import MfpInvoiceListSkeletonLoad from "@/views/invoice/MfpInvoiceListSkeletonLoad.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import MfpInvoiceListItem from "@/views/invoice/MfpInvoiceListItem.vue"
import MfpTotalRegistersRow from "@/modules/@shared/components/page/MfpTotalRegistersRow.vue"
import {InvoiceModel} from "@/model/invoice/invoiceModel"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {useCardsStore} from "@/modules/credit-cards/store/CardsStore"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpCardInvoicesFormModal from "@/modules/credit-cards/component/MfpCardInvoicesFormModal.vue"
import {CardInvoiceItemService} from "@/modules/credit-cards/service/CardInvoiceItemService"
import MfpCardInvoicesDetailsCard from "@/modules/credit-cards/component/MfpCardInvoicesDetailsCard.vue"

const invoiceStore = useCardInvoicesStore()
const cardStore = useCardsStore()
const cardId = ref(useRoute().params.id)
const formModal = new MfpModal(MfpCardInvoicesFormModal)

const card = ref()

async function optionsAction(item: InvoiceModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtons(true, true, true))
    const action = await actionSheet.open()
    if (action == 'edit') {
        const invoiceItem = await CardInvoiceItemService.get(item.id)
        await formModal.open({invoiceItem})
    } else if (action == 'delete') {
        await CardInvoiceItemService.delete(item, parseInt(String(cardId.value)))
        await loadInvoices()
    }
}

async function loadInvoices(): Promise<void> {
    await invoiceStore.load(String(cardId.value))
    await cardStore.load()
    card.value = cardStore.cards.find(card => card.id == cardId.value)
}

async function handleRefresh(event: any) {
    await loadInvoices()
    event.target.complete()
}

onMounted(async () => {
    await loadInvoices()
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Faturas Cartão {{ card?.name }}</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-period-switcher :store="invoiceStore"/>
        <mfp-card-invoices-details-card/>
        <mfp-empty-list-item :nothing-to-show="invoiceStore.invoice.length === 0 && invoiceStore.isLoaded"/>
        <mfp-invoice-list-skeleton-load :is-loaded="invoiceStore.isLoaded"/>
        <ion-list v-if="invoiceStore.isLoaded">
            <ion-item-sliding v-for="(item, index) in invoiceStore.invoice" :key="index">
                <mfp-invoice-list-item :invoice-item="item" :store="invoiceStore" fix-installment-label="Parcela"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="invoiceStore.invoice.length"/>
    </mfp-page>
</template>
