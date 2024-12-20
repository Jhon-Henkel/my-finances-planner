<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {ref} from "vue"
import {useRoute} from "vue-router"
import {
    IonButton,
    IonIcon,
    IonItemOption,
    IonItemOptions,
    IonItemSliding,
    IonLabel,
    IonList,
    IonListHeader,
    onIonViewDidEnter
} from "@ionic/vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import MfpInvoiceListSkeletonLoad from "@/modules/invoice/component/MfpInvoiceListSkeletonLoad.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import {useCreditCardInvoiceStore} from "@/modules/credit-card/store/CreditCardInvoiceStore"
import {useCreditCardStore} from "@/modules/credit-card/store/CreditCardStore"
import MfpCreditCardInvoiceFormModal from "@/modules/credit-card/component/MfpCreditCardInvoiceFormModal.vue"
import MfpPeriodSwitcherV2 from "@/modules/@shared/components/switcher/MfpPeriodSwitcherV2.vue"
import MfpCreditCardInvoicesDetailsCard from "@/modules/credit-card/component/MfpCreditCardInvoicesDetailsCard.vue"
import MfpEmptyListItemV2 from "@/modules/@shared/components/list/MfpEmptyListItemV2.vue"
import MfpInvoiceListItemV2 from "@/modules/invoice/component/MfpInvoiceListItemV2.vue"
import ICreditCardInvoiceListDto from "@/modules/credit-card/dto/credit-card.invoice.list.dto"
import MfpTotalRegistersRowV2 from "@/modules/@shared/components/page/MfpTotalRegistersRowV2.vue"
import MfpCreditCardPayModal from "@/modules/credit-card/component/MfpCreditCardPayModal.vue"
import {CreditCardInvoiceItemService} from "@/modules/credit-card/service/CreditCardInvoiceItemService"

const invoiceStore = useCreditCardInvoiceStore()
const cardStore = useCreditCardStore()
const cardId = ref(useRoute().params.id)
const formModal = new MfpModal(MfpCreditCardInvoiceFormModal)

const card = ref()

async function optionsAction(item: ICreditCardInvoiceListDto) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtons(true, true, true))
    const action = await actionSheet.open()
    if (action == 'edit') {
        const invoiceItem = await CreditCardInvoiceItemService.get(item.id)
        await formModal.open({invoiceItem})
    } else if (action == 'delete') {
        await CreditCardInvoiceItemService.delete(item, parseInt(String(cardId.value)))
        await loadInvoices()
    }
}

async function loadInvoices(): Promise<void> {
    await invoiceStore.load(String(cardId.value))
    if (! cardStore.isLoaded) {
        await cardStore.load()
    }
    card.value = cardStore.cards.find(card => card.id == cardId.value)
}

async function handleRefresh(event: any) {
    await loadInvoices()
    event.target.complete()
}

async function payInvoice() {
    const payModal = new MfpModal(MfpCreditCardPayModal)
    await payModal.open({item: card.value})
}

onIonViewDidEnter(() => {
    loadInvoices()
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Faturas Cartão {{ card?.name }}</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-period-switcher-v2 :store="invoiceStore"/>
        <mfp-credit-card-invoices-details-card :store="invoiceStore"/>
        <ion-button
            expand="block"
            @click="payInvoice()"
            v-if="invoiceStore.pageTotalItems > 0"
            class="ion-margin-end ion-margin-start ion-margin-top"
        >
            Pagar Próxima Fatura
        </ion-button>
        <mfp-empty-list-item-v2 :store="invoiceStore"/>
        <mfp-invoice-list-skeleton-load :is-loaded="invoiceStore.isLoaded"/>
        <ion-list v-if="invoiceStore.isLoaded">
            <ion-item-sliding v-for="(item, index) in invoiceStore.invoice" :key="index">
                <mfp-invoice-list-item-v2 :invoice-item="item" :store="invoiceStore" fix-installment-label="Parcela" :is-credit-card-item="true"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row-v2 :store="invoiceStore"/>
    </mfp-page>
</template>
