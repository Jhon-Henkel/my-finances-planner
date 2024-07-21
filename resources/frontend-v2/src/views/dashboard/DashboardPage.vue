<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import {IonGrid, IonLabel, IonListHeader} from "@ionic/vue"
import MfpUserSettingsModal from "@/views/settings/user/MfpUserSettingsModal.vue"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpCircleUserButton from "@/components/button/MfpCircleUserButton.vue"
import MfpDashboardTotalWalletAmountCard from "@/views/dashboard/MfpDashboardTotalWalletAmountCard.vue"
import MfpDashboardPlannerAmountCard from "@/views/dashboard/MfpDashboardPlannerAmountCard.vue"
import MfpDashboardMovementAmountCard from "@/views/dashboard/MfpDashboardMovementAmountCard.vue"
import MfpDashboardMonthLabel from "@/views/dashboard/MfpDashboardMonthLabel.vue"
import MfpDashboardLastMovementsCard from "@/views/dashboard/MfpDashboardLastMovementsCard.vue"
import MfpDashboardScheduledForTheMonthCard from "@/views/dashboard/MfpDashboardScheduledForTheMonthCard.vue"

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
            <mfp-dashboard-scheduled-for-the-month-card/>
            <mfp-dashboard-last-movements-card/>
        </ion-grid>
    </mfp-page>
</template>
