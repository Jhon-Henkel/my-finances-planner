<script setup lang="ts">
import {IonBadge, IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {chevronBackOutline} from "ionicons/icons"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import EarningPlanApiGetDto from "@/modules/earning-plan/dto/earning-plan.api.get.dto"

const props = defineProps({
    invoiceItem: {
        type: Object as () => EarningPlanApiGetDto,
        required: true
    },
    store: {
        type: Object,
        required: true
    }
})

function getColorForNextInstallmentDay(): string {
    const dateToday = UtilCalendar.getToday()
    const dateNextInstallment = UtilCalendar.makeDate(props.store.dateSearch)
    dateNextInstallment.setDate(UtilCalendar.makeDate(props.invoiceItem.forecast).getDate())
    if (dateNextInstallment.getTime() > dateToday.getTime()) {
        return 'success'
    }
    if (dateNextInstallment.getDate() < dateToday.getDate() && dateNextInstallment.getMonth() === dateToday.getMonth()) {
        return 'danger'
    }
    return 'warning'
}
</script>

<template>
    <ion-item>
        <ion-grid>
            <ion-row class="center-ion-label-content">
                <ion-col size="1">
                    <ion-badge :color="getColorForNextInstallmentDay()">
                        {{ UtilCalendar.makeDate(invoiceItem.forecast).getDate() }}
                    </ion-badge>
                </ion-col>
                <ion-col size="6">
                    <ion-row>
                        <ion-col class="ion-padding-start">
                            <ion-label class="no-break text-truncate">
                                <strong>{{ invoiceItem.description }}</strong>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col size="6" class="ion-padding-start">
                            <ion-label class="no-break" v-if="invoiceItem.installments == 1">
                                Restam {{ invoiceItem.installments }} parcela
                            </ion-label>
                            <ion-label class="no-break" v-else-if="invoiceItem.installments > 0">
                                Restam {{ invoiceItem.installments }} parcelas
                            </ion-label>
                            <ion-label class="no-break" v-else>
                                Receita Fixa
                            </ion-label>
                        </ion-col>
                    </ion-row>
                </ion-col>
                <ion-col size="4" class="ion-text-end">
                    <ion-label>
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.amount) }}
                    </ion-label>
                </ion-col>
                <ion-col size="1" class="ion-text-end no-padding-end">
                    <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
