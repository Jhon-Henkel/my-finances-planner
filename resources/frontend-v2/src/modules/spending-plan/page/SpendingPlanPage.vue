<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import {checkmarkOutline, ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/modules/@shared/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/modules/@shared/util/UtilActionSheet"
import {onMounted} from "vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import MfpInvoiceListSkeletonLoad from "@/modules/invoice/component/MfpInvoiceListSkeletonLoad.vue"
import MfpInvoiceDetailsModal from "@/modules/invoice/component/MfpInvoiceDetailsModal.vue"
import {useSpendingPlanStore} from "@/modules/spending-plan/store/SpendingPlanStore"
import MfpSpendingPlanFormModal from "@/modules/spending-plan/component/MfpSpendingPlanFormModal.vue"
import SpendingPlanApiGetDto from "@/modules/spending-plan/dto/spending-plan.api.get.dto"
import {SpendingPlanService} from "@/modules/spending-plan/service/SpendingPlanService"
import MfpSpendingPlanPayModal from "@/modules/spending-plan/component/MfpSpendingPlanPayModal.vue"
import MfpPeriodSwitcherV2 from "@/modules/@shared/components/switcher/MfpPeriodSwitcherV2.vue"
import MfpEmptyListItemV2 from "@/modules/@shared/components/list/MfpEmptyListItemV2.vue"
import MfpTotalRegistersRowV2 from "@/modules/@shared/components/page/MfpTotalRegistersRowV2.vue"
import MfpSpendingPlanDetailsCard from "@/modules/spending-plan/component/MfpSpendingPlanDetailsCard.vue"
import MfpSpendingPlanAddValueModal from "@/modules/spending-plan/component/MfpSpendingPlanAddValueModal.vue"
import MfpInvoiceListItemV2 from "@/modules/invoice/component/MfpInvoiceListItemV2.vue"

const store = useSpendingPlanStore()
const formModal = new MfpModal(MfpSpendingPlanFormModal)
const okAlert = new MfpOkAlert('Ação inválida!')

async function optionsAction(item: SpendingPlanApiGetDto) {
    if (item.id == 0 && item.wallet_id == 0) {
        let message = 'Essa despesa é apenas do tipo informativa, não é possível fazer nenhuma ação com ela. '
        message += 'Conforme for marcando movimentações com esse nome o valor será atualizado automaticamente.'
        await okAlert.open(message)
        return
    }
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToPanorama())
    const action = await actionSheet.open()
    if (action === 'edit') {
        const futureExpense = await SpendingPlanService.get(item.id)
        futureExpense.forecast = UtilCalendar.toIso(futureExpense.forecast)
        await formModal.open({futureExpense: futureExpense})
    } else if (action === 'delete') {
        await SpendingPlanService.delete(item)
    } else if (action === 'pay') {
        await pay(item)
    } else if (action === 'add-value') {
        const futureExpense = await SpendingPlanService.get(item.id)
        const addValueModal = new MfpModal(MfpSpendingPlanAddValueModal)
        await addValueModal.open({futureExpense: futureExpense})
    } else if (action === 'details') {
        const futureExpense = await SpendingPlanService.get(item.id)
        const details = new MfpModal(MfpInvoiceDetailsModal)
        await details.open({item: futureExpense})
    }
}

async function pay(item: SpendingPlanApiGetDto) {
    const payModal = new MfpModal(MfpSpendingPlanPayModal)
    await payModal.open({item: item, store: store})
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
            <ion-label>Plano de Gastos</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-period-switcher-v2 :store="store"/>
        <mfp-spending-plan-details-card :store="store"/>
        <mfp-empty-list-item-v2 :store="store"/>
        <mfp-invoice-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding v-for="(item, index) in store.spendingPlan" :key="index">
                <mfp-invoice-list-item-v2 :store="store" :invoice-item="item" fix-installment-label="Despesa"/>
                <ion-item-options side="end">
                    <ion-item-option color="success" @click="pay(item)">
                        <ion-icon slot="top" :icon="checkmarkOutline"/>
                        Pagar
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
