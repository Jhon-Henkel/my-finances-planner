<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {IonGrid, IonLabel, IonListHeader} from "@ionic/vue"
import MfpUserSettingsModal from "@/modules/setings/modal/user/MfpUserSettingsModal.vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpCircleUserButton from "@/modules/@shared/components/button/MfpCircleUserButton.vue"
import MfpDashboardTotalWalletAmountCard from "@/modules/dashboard/component/total-wallet/MfpDashboardTotalWalletAmountCard.vue"
import MfpDashboardPlannerAmountCard from "@/modules/dashboard/component/planner-amount/MfpDashboardPlannerAmountCard.vue"
import MfpDashboardMonthLabel from "@/modules/dashboard/component/month-label/MfpDashboardMonthLabel.vue"
import MfpDashboardLastMovementsCard from "@/modules/dashboard/component/last-movements/MfpDashboardLastMovementsCard.vue"
import MfpDashboardMarketPlannerCard
    from "@/modules/dashboard/component/marketplanner/MfpDashboardMarketPlannerCard.vue"
import {useMovementStore} from "@/modules/movement/store/MovementStore"
import MfpBalanceCard from "@/modules/@shared/components/card/MfpBalanceCard.vue"
import MfpExpensesAndIncomesDoubleInlineCards
    from "@/modules/@shared/components/card/MfpExpensesAndIncomesDoubleInlineCards.vue"

const userModal = new MfpModal(MfpUserSettingsModal)
const movementStore = useMovementStore()
</script>

<template>
    <mfp-page>
        <ion-list-header>
            <ion-label>Dashboard</ion-label>
            <mfp-circle-user-button @click="userModal.open()"/>
        </ion-list-header>
        <mfp-dashboard-month-label/>
        <ion-grid>
            <mfp-dashboard-total-wallet-amount-card/>
            <mfp-expenses-and-incomes-double-inline-cards
                :incomes="movementStore.thisMonthTotalIncomesValue"
                :expenses="movementStore.thisMonthTotalExpensesValue"
            />
            <mfp-dashboard-planner-amount-card/>
            <mfp-dashboard-market-planner-card/>
            <mfp-balance-card :balance="movementStore.thisMonthTotalBalance"/>
            <mfp-dashboard-last-movements-card/>
        </ion-grid>
    </mfp-page>
</template>
