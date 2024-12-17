<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import {onMounted} from "vue"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import MfpInvoiceListSkeletonLoad from "@/modules/invoice/component/MfpInvoiceListSkeletonLoad.vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import MfpInvoiceDetailsModal from "@/modules/invoice/component/MfpInvoiceDetailsModal.vue"
import {useEarningPlanStore} from "@/modules/earning-plan/store/EarningPlanStore"
import MfpTotalRegistersRowV2 from "@/modules/@shared/components/page/MfpTotalRegistersRowV2.vue"
import MfpPeriodSwitcherV2 from "@/modules/@shared/components/switcher/MfpPeriodSwitcherV2.vue"
import MfpEarningPlanDetailsCard from "@/modules/earning-plan/component/MfpEarningPlanDetailsCard.vue"
import MfpEmptyListItemV2 from "@/modules/@shared/components/list/MfpEmptyListItemV2.vue"
import MfpEarningPlanFormModal from "@/modules/earning-plan/component/MfpEarningPlanFormModal.vue"
import MfpEarningPlanListItem from "@/modules/earning-plan/component/MfpEarningPlanListItem.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import EarningPlanApiGetDto from "@/modules/earning-plan/dto/earning-plan.api.get.dto"
import {EarningPlanService} from "@/modules/earning-plan/service/EarningPlanService"
import MfpEarningPlanReceiveModal from "@/modules/earning-plan/component/MfpEarningPlanReceiveModal.vue"

const store = useEarningPlanStore()
const formModal = new MfpModal(MfpEarningPlanFormModal)

async function optionsAction(item: EarningPlanApiGetDto) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToFutureProfits())
    const action = await actionSheet.open()
    if (action === 'edit') {
        const futureProfit = await EarningPlanService.get(item.id)
        futureProfit.forecast = UtilCalendar.toIso(futureProfit.forecast)
        await formModal.open({futureProfit: futureProfit})
    } else if (action === 'delete') {
        await EarningPlanService.delete(item)
    } else if (action === 'receive') {
        const receiveModal = new MfpModal(MfpEarningPlanReceiveModal)
        await receiveModal.open({item: item})
    } else if (action === 'details') {
        const futureProfit = await EarningPlanService.get(item.id)
        const details = new MfpModal(MfpInvoiceDetailsModal)
        await details.open({item: futureProfit, totalLabel: 'Total a Receber'})
    }
}

async function handleRefresh(event: any) {
    await store.load()
    event.target.complete()
}

onMounted(async () => {
    await store.load()
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Plano de Receitas</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-period-switcher-v2 :store="store"/>
        <mfp-earning-plan-details-card :store="store"/>
        <mfp-empty-list-item-v2 :store="store"/>
        <mfp-invoice-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding v-for="(item, index) in store.earningPlan" :key="index">
                <mfp-earning-plan-list-item :store="store" :invoice-item="item"/>
                <ion-item-options side="end">
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
