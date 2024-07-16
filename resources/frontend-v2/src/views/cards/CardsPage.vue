<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import MfpTotalRegistersRow from "@/components/page/MfpTotalRegistersRow.vue"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import {onMounted} from "vue"
import {useCardsStore} from "@/stores/cards/CardsStore"
import MfpCardsListItem from "@/views/cards/MfpCardsListItem.vue"
import {CardModel} from "@/model/card/CardModel"
import MfpCardsListSkeletonLoad from "@/views/cards/MfpCardsListSkeletonLoad.vue"
import {CardsService} from "@/services/cards/CardsService"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpCardsFormModal from "@/views/cards/MfpCardsFormModal.vue"

const store = useCardsStore()
const formModal = new MfpModal(MfpCardsFormModal)

async function optionsAction(item: CardModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToCards())
    const action = await actionSheet.open()
    if (action === 'edit') {
        await formModal.open({card: item})
    } else if (action === 'delete') {
        await CardsService.delete(item)
    }
    console.log(action, item)
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
