<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow, IonBadge} from "@ionic/vue"
import {chevronBackOutline} from "ionicons/icons"
import {UtilString} from "@/util/UtilString"
import {UtilMoney} from "@/util/UtilMoney"
import {IInvoice} from "@/services/invoice/IInvoice"
import {usePanoramaStore} from "@/stores/panorama/PanoramaStore"
import {UtilCalendar} from "@/util/UtilCalendar"

const store = usePanoramaStore()
const props = defineProps({
    panoramaItem: {
        type: Object as () => IInvoice,
        required: true
    }
})

function getColorForNextInstallmentDay(installment: number): string {
    const today = UtilCalendar.getToday()
    const nextInstallmentDay = UtilCalendar.makeDate(props.panoramaItem.nextInstallmentDate)
    if ((nextInstallmentDay < today) && (props.panoramaItem.firstInstallment > 0) && installment == 1) {
        return 'danger'
    } else if ((nextInstallmentDay >= today) && (props.panoramaItem.firstInstallment > 0) && installment == 1) {
        return 'warning'
    }
    return 'success'

}
</script>

<template>
    <ion-item>
        <ion-grid>
            <ion-row class="center-ion-label-content">
                <ion-col size="1">
                    <ion-badge :color="getColorForNextInstallmentDay(store.installmentSelected)">
                        {{ panoramaItem.nextInstallmentDay }}
                    </ion-badge>
                </ion-col>
                <ion-col size="6">
                    <ion-row>
                        <ion-col class="ion-padding-start">
                            <ion-label class="no-break">
                                <strong>
                                    {{ UtilString.ellipsis(panoramaItem.name, 24) }}
                                </strong>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col size="6" class="ion-padding-start">
                            <ion-label class="no-break" v-if="panoramaItem.remainingInstallments === 1">
                                Restam {{ panoramaItem.remainingInstallments }} parcela
                            </ion-label>
                            <ion-label class="no-break" v-else-if="panoramaItem.remainingInstallments > 0">
                                Restam {{ panoramaItem.remainingInstallments }} parcelas
                            </ion-label>
                            <ion-label class="no-break" v-else>
                                Despesa Fixa
                            </ion-label>
                        </ion-col>
                    </ion-row>
                </ion-col>
                <ion-col size="4" class="ion-text-end">
                    <ion-label v-if="store.installmentSelected === 1">
                        {{ UtilMoney.formatValueToBrReturnHyphenCaseZero(panoramaItem.firstInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 2">
                        {{ UtilMoney.formatValueToBrReturnHyphenCaseZero(panoramaItem.secondInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 3">
                        {{ UtilMoney.formatValueToBrReturnHyphenCaseZero(panoramaItem.thirdInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 4">
                        {{ UtilMoney.formatValueToBrReturnHyphenCaseZero(panoramaItem.fourthInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 5">
                        {{ UtilMoney.formatValueToBrReturnHyphenCaseZero(panoramaItem.fifthInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 6">
                        {{ UtilMoney.formatValueToBrReturnHyphenCaseZero(panoramaItem.sixthInstallment) }}
                    </ion-label>
                </ion-col>
                <ion-col size="1" class="ion-text-end no-padding-end">
                    <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
