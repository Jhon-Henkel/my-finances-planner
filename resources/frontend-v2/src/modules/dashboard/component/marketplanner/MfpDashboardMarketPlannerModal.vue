<script setup lang="ts">
import {cartOutline, informationCircleOutline} from "ionicons/icons"
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonProgressBar, IonRow} from "@ionic/vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import {UtilMoney} from "@/util/UtilMoney"
import {useMovementStore} from "@/stores/movement/MovementStore"

const store = useMovementStore()

function marketInfo() {
    const remainingLimit = UtilMoney.formatValueToBr(store.marketPlannerDetails.this_month_remaining_limit)
    const alert = new MfpOkAlert('Plano Mercado')
    alert.open(`Você ainda pode gastar ${remainingLimit} no mercado!`)
}
</script>

<template>
    <ion-row v-show="store.marketPlannerDetails.use_market_planner">
        <ion-col>
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin center-ion-label-content">
                    <ion-col size="2">
                        <ion-icon :icon="cartOutline" size="large" color="primary"/>
                    </ion-col>
                    <ion-col size="10">
                        <ion-card-subtitle class="center-vertical-ion-label-content">
                            Plano Mercado
                            <ion-icon
                                :icon="informationCircleOutline"
                                size="small"
                                color="primary"
                                class="icon-start"
                                @click="marketInfo"
                            />
                        </ion-card-subtitle>
                        <mfp-counter-money :end="store.marketPlannerDetails.this_month_spent"/> /
                        <mfp-counter-money :end="store.marketPlannerDetails.total_limit"/>
                        <ion-progress-bar :value="store.marketPlannerDetails.percent_used" class="ion-margin-top"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
