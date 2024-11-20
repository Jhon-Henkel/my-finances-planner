<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {IonGrid, IonLabel, IonListHeader} from "@ionic/vue"
import MfpUserSettingsModal from "@/modules/setings/modal/user/MfpUserSettingsModal.vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpCircleUserButton from "@/modules/@shared/components/button/MfpCircleUserButton.vue"
import MfpDashboardTotalWalletAmountCard from "@/modules/dashboard/component/total-wallet/MfpDashboardTotalWalletAmountCard.vue"
import MfpDashboardPlannerAmountCard from "@/modules/dashboard/component/planner-amount/MfpDashboardPlannerAmountCard.vue"
import MfpDashboardMovementAmountCard from "@/modules/dashboard/component/movement-amount/MfpDashboardMovementAmountCard.vue"
import MfpDashboardMonthLabel from "@/modules/dashboard/component/month-label/MfpDashboardMonthLabel.vue"
import MfpDashboardLastMovementsCard from "@/modules/dashboard/component/last-movements/MfpDashboardLastMovementsCard.vue"
import MfpDashboardScheduledForTheMonthCard from "@/modules/dashboard/component/schedule-for-this-month/MfpDashboardScheduledForTheMonthCard.vue"
import MfpDashboardMarketPlannerModal from "@/modules/dashboard/component/marketplanner/MfpDashboardMarketPlannerModal.vue"

const userModal = new MfpModal(MfpUserSettingsModal)
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
            <mfp-dashboard-movement-amount-card/>
            <mfp-dashboard-planner-amount-card/>
            <mfp-dashboard-market-planner-modal/>
            <mfp-dashboard-scheduled-for-the-month-card/>
            <mfp-dashboard-last-movements-card/>
        </ion-grid>
    </mfp-page>
</template>
