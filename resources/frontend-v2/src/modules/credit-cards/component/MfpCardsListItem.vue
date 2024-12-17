<script setup lang="ts">
import {IonGrid, IonRow, IonCol, IonProgressBar, IonLabel, IonItem, IonIcon, IonBadge} from "@ionic/vue"
import {CardModel} from "@/modules/credit-cards/model/CardModel"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {ref} from "vue"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {chevronBackOutline} from "ionicons/icons"

const props = defineProps({
    card: {
        type: CardModel,
        required: true
    }
})

const remainingLimit = ref(props.card.limit - props.card.totalValueSpending)
const usedLimitPercentage: number = ((props.card.limit - remainingLimit.value) / props.card.limit)

function makeDueDate() {
    const month = UtilCalendar.getToday().getMonth()
    const monthName = UtilCalendar.getMonthNameByNumber(month)
    return `${props.card.dueDate}/${monthName.slice(0, 3)}.`
}

function getColorForForecast() {
    const today = UtilCalendar.getToday().getDate()
    if (props.card.isThisMonthInvoicePayed) {
        return 'success'
    } else if (props.card.dueDate < today) {
        return 'danger'
    } else if (props.card.dueDate > today) {
        return 'warning'
    }
}
</script>

<template>
    <ion-item>
        <ion-grid>
            <ion-row class="center-ion-label-content">
                <ion-col size="11">
                    <ion-row>
                        <ion-col size="6">
                            <ion-label class="text-truncate">
                                {{ card.name }}
                            </ion-label>
                        </ion-col>
                        <ion-col size="6" class="ion-text-end">
                            <ion-label v-if="card.dueDate">
                                <ion-badge :color="getColorForForecast()">
                                    {{ makeDueDate() }}
                                </ion-badge>
                            </ion-label>
                            <ion-label v-else>
                                <p>-</p>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col>
                            <ion-label class="ion-text-start">
                                <p>Prox. Fatura</p>
                            </ion-label>
                        </ion-col>
                        <ion-col>
                            <ion-label class="ion-text-end">
                                <p>{{ UtilMoney.formatValueToBr(card.nextInvoiceValue) }}</p>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col>
                            <ion-progress-bar :value="usedLimitPercentage"/>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col>
                            <ion-label class="ion-text-start">
                                <p>Limite Disponível</p>
                            </ion-label>
                        </ion-col>
                        <ion-col>
                            <ion-label class="ion-text-end">
                                <p>{{ UtilMoney.formatValueToBr(remainingLimit) }}</p>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                </ion-col>
                <ion-col size="1" class="ion-text-end no-padding-end">
                    <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
