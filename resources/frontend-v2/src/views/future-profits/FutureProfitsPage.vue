<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import {IonIcon, IonLabel, IonListHeader, IonList, IonItemSliding, IonItemOption, IonItemOptions} from "@ionic/vue"
import {useFutureProfitsStore} from "@/stores/future-profits/FutureProfitsStore"
import {onMounted} from "vue"
import MfpPeriodSwitcher from "@/components/switcher/MfpPeriodSwitcher.vue"
import MfpTotalRegistersRow from "@/components/page/MfpTotalRegistersRow.vue"
import MfpFutureProfitsDetailsCard from "@/views/future-profits/MfpFutureProfitsDetailsCard.vue"
import {FutureProfitsService} from "@/services/future-profits/FutureProfitsService"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import {FutureProfitsModel} from "@/model/future-profits/FutureProfitsModel"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import MfpInvoiceListItem from "@/views/invoice/MfpInvoiceListItem.vue"
import MfpInvoiceListSkeletonLoad from "@/views/invoice/MfpInvoiceListSkeletonLoad.vue"

const store = useFutureProfitsStore()

async function optionsAction(item: FutureProfitsModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToFutureProfits())
    const action = await actionSheet.open()
    console.log(action, item)
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
            <mfp-circle-plus-button/>
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
