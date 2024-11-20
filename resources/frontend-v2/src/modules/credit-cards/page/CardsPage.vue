<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import MfpEmptyListItem from "@/modules/@shared/components/list/MfpEmptyListItem.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import MfpTotalRegistersRow from "@/modules/@shared/components/page/MfpTotalRegistersRow.vue"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {onMounted} from "vue"
import {useCardsStore} from "@/modules/credit-cards/store/CardsStore"
import MfpCardsListItem from "@/modules/credit-cards/component/MfpCardsListItem.vue"
import {CardModel} from "@/modules/credit-cards/model/CardModel"
import MfpCardsListSkeletonLoad from "@/modules/credit-cards/component/MfpCardsListSkeletonLoad.vue"
import {CardsService} from "@/modules/credit-cards/service/CardsService"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpCardsFormModal from "@/modules/credit-cards/component/MfpCardsFormModal.vue"
import MfpCardsPayModal from "@/modules/credit-cards/component/MfpCardsPayModal.vue"
import MfpCardsDetailsModal from "@/modules/credit-cards/component/MfpCardsDetailsModal.vue"
import MfpCardInvoicesFormModal from "@/modules/credit-cards/component/MfpCardInvoicesFormModal.vue"

const store = useCardsStore()
const formModal = new MfpModal(MfpCardsFormModal)

async function optionsAction(item: CardModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToCards())
    const action = await actionSheet.open()
    if (action === 'edit') {
        await formModal.open({card: item})
    } else if (action === 'delete') {
        await CardsService.delete(item)
    } else if (action === 'new-invoice-item') {
        const invoiceFormModal = new MfpModal(MfpCardInvoicesFormModal)
        await invoiceFormModal.open({cardIdProp: item.id})
    } else if (action === 'see-invoices') {
        window.location.href = `v2/gerenciar-cartoes/fatura-cartao/${item.id}`
    } else if (action === 'pay') {
        const payModal = new MfpModal(MfpCardsPayModal)
        await payModal.open({item: item})
    } else if (action == 'details') {
        const detailsModal = new MfpModal(MfpCardsDetailsModal)
        await detailsModal.open({item: item})
    }
}

async function handleRefresh(event: any) {
    await CardsService.forceReloadStore()
    event.target.complete()
}

onMounted(async () => {
    if (! store.isLoaded) {
        await store.load()
    }
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Cartões</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-empty-list-item :nothing-to-show="store.cards.length === 0 && store.isLoaded"/>
        <mfp-cards-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding v-for="(item, index) in store.cards" :key="index">
                <mfp-cards-list-item :card="item"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="store.cards.length"/>
    </mfp-page>
</template>
