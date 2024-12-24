<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import {documentTextOutline, ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {onMounted} from "vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpCreditCardFormModal from "@/modules/credit-card/component/MfpCreditCardFormModal.vue"
import {CreditCardModel} from "@/modules/credit-card/model/CreditCardModel"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"
import MfpCreditCardPayModal from "@/modules/credit-card/component/MfpCreditCardPayModal.vue"
import MfpCreditCardDetailsModal from "@/modules/credit-card/component/MfpCreditCardDetailsModal.vue"
import MfpCreditCardListSkeletonLoad from "@/modules/credit-card/component/MfpCreditCardListSkeletonLoad.vue"
import MfpCreditCardListItem from "@/modules/credit-card/component/MfpCreditCardListItem.vue"
import MfpTotalRegistersRowV2 from "@/modules/@shared/components/page/MfpTotalRegistersRowV2.vue"
import {useCreditCardStore} from "@/modules/credit-card/store/CreditCardStore"
import MfpEmptyListItemV2 from "@/modules/@shared/components/list/MfpEmptyListItemV2.vue"
import router from "@/infra/router"
import {RouteName} from "@/infra/router/routeName"
import MfpCreditCardInvoiceFormModal from "@/modules/credit-card/component/MfpCreditCardInvoiceFormModal.vue"

const store = useCreditCardStore()
const formModal = new MfpModal(MfpCreditCardFormModal)

async function optionsAction(item: CreditCardModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToCards())
    const action = await actionSheet.open()
    if (action === 'edit') {
        await formModal.open({card: item})
    } else if (action === 'delete') {
        await CreditCardService.delete(item)
    } else if (action === 'new-invoice-item') {
        const invoiceFormModal = new MfpModal(MfpCreditCardInvoiceFormModal)
        await invoiceFormModal.open({cardIdProp: item.id})
    } else if (action === 'see-invoices') {
        await goToInvoice(item.id)
    } else if (action === 'pay') {
        const payModal = new MfpModal(MfpCreditCardPayModal)
        await payModal.open({item: item})
    } else if (action == 'details') {
        const detailsModal = new MfpModal(MfpCreditCardDetailsModal)
        await detailsModal.open({item: item})
    }
}

async function handleRefresh(event: any) {
    await CreditCardService.reloadStore()
    event.target.complete()
}

async function goToInvoice(creditCardId: number|string) {
    await router.push({name: RouteName.credit_card_invoices, params: {id: creditCardId}})
}

onMounted(async () => {
    await store.load()
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Cartões</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-empty-list-item-v2 :store="store"/>
        <mfp-credit-card-list-skeleton-load :store="store"/>
        <ion-list v-if="store.isLoaded">
            <ion-list-header v-show="store.activeCards.length > 0">
                <ion-label>Ativo</ion-label>
            </ion-list-header>
            <ion-item-sliding v-for="(item, index) in store.activeCards" :key="index">
                <mfp-credit-card-list-item :card="item"/>
                <ion-item-options side="end">
                    <ion-item-option color="primary" @click="goToInvoice(item.id)">
                        <ion-icon slot="top" :icon="documentTextOutline"/>
                        Faturas
                    </ion-item-option>
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
            <ion-list-header v-show="store.inactiveCards.length > 0">
                <ion-label>Inativo</ion-label>
            </ion-list-header>
            <ion-item-sliding v-for="(item, index) in store.inactiveCards" :key="index">
                <mfp-credit-card-list-item :card="item"/>
                <ion-item-options side="end">
                    <ion-item-option color="primary" @click="goToInvoice(item.id)">
                        <ion-icon slot="top" :icon="documentTextOutline"/>
                        Faturas
                    </ion-item-option>
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row-v2 :store="store"/>
    </mfp-page>
</template>
