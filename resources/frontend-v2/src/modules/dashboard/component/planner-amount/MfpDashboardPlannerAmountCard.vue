<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow} from '@ionic/vue'
import {onMounted} from "vue"
import MfpCounterMoney from "@/modules/@shared/components/counter/MfpCounterMoney.vue"
import {calendarNumberOutline, cashOutline} from "ionicons/icons"
import router from "../../../../infra/router"
import {RouteName} from "@/infra/router/routeName"
import {useSpendingPlanStore} from "@/modules/spending-plan/store/SpendingPlanStore"

const spendingPlanStore = useSpendingPlanStore()

onMounted(async () => {
    await spendingPlanStore.load()
})
</script>

<template>
    <ion-row>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light" @click="router.push({name: RouteName.earning_plan})">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="cashOutline" size="large" color="success"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Receber</ion-card-subtitle>
                        <mfp-counter-money :end="spendingPlanStore.earningsThisMonthTotalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
        <ion-col size="6">
            <ion-card class="ion-no-margin" color="light" @click="router.push({name: RouteName.spending_plan})">
                <ion-row class="ion-margin">
                    <ion-col size="3">
                        <ion-icon :icon="calendarNumberOutline" size="large" color="danger"/>
                    </ion-col>
                    <ion-col size="9">
                        <ion-card-subtitle>Pagar</ion-card-subtitle>
                        <mfp-counter-money :end="spendingPlanStore.thisMonthTotalAmount + spendingPlanStore.creditCardsThisMonthTotalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
