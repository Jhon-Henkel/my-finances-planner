<script setup lang="ts">
import {IonBadge, IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {checkmarkCircleOutline, chevronBackOutline} from "ionicons/icons"
import {UtilString} from "@/modules/@shared/util/UtilString"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {IInvoice} from "@/services/invoice/IInvoice"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"

const props = defineProps({
    invoiceItem: {
        type: Object as () => IInvoice,
        required: true
    },
    store: {
        type: Object,
        required: true
    },
    fixInstallmentLabel: {
        type: String,
        required: false,
        default: 'Despesa'
    }
})
const store = props.store

function getColorForNextInstallmentDay(installment: number): string {
    const today = UtilCalendar.getToday()
    const nextInstallmentDay = UtilCalendar.makeDate(props.invoiceItem.nextInstallmentDate)
    if ((nextInstallmentDay < today) && (props.invoiceItem.firstInstallment > 0) && installment == 1) {
        return 'danger'
    } else if ((nextInstallmentDay >= today) && (props.invoiceItem.firstInstallment > 0) && installment == 1) {
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
                        {{ invoiceItem.nextInstallmentDay }}
                    </ion-badge>
                </ion-col>
                <ion-col size="6">
                    <ion-row>
                        <ion-col class="ion-padding-start">
                            <ion-label class="no-break">
                                <strong>
                                    {{ UtilString.ellipsis(invoiceItem.name, 24) }}
                                </strong>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col size="6" class="ion-padding-start">
                            <ion-label class="no-break" v-if="invoiceItem.remainingInstallments === 1">
                                Restam {{ invoiceItem.remainingInstallments }} parcela
                            </ion-label>
                            <ion-label class="no-break" v-else-if="invoiceItem.remainingInstallments > 0">
                                Restam {{ invoiceItem.remainingInstallments }} parcelas
                            </ion-label>
                            <ion-label class="no-break" v-else>
                                {{ fixInstallmentLabel }} Fixa
                            </ion-label>
                        </ion-col>
                    </ion-row>
                </ion-col>
                <ion-col size="4" class="ion-text-end">
                    <ion-label v-if="store.installmentSelected === 1">
                        <ion-icon
                            :icon="checkmarkCircleOutline"
                            color="success"
                            v-if="invoiceItem.firstInstallment == 0"
                        />
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.firstInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 2">
                        <ion-icon
                            :icon="checkmarkCircleOutline"
                            color="success"
                            v-if="invoiceItem.secondInstallment == 0"
                        />
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.secondInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 3">
                        <ion-icon
                            :icon="checkmarkCircleOutline"
                            color="success"
                            v-if="invoiceItem.thirdInstallment == 0"
                        />
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.thirdInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 4">
                        <ion-icon
                            :icon="checkmarkCircleOutline"
                            color="success"
                            v-if="invoiceItem.fourthInstallment == 0"
                        />
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.fourthInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 5">
                        <ion-icon
                            :icon="checkmarkCircleOutline"
                            color="success"
                            v-if="invoiceItem.fifthInstallment == 0"
                        />
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.fifthInstallment) }}
                    </ion-label>
                    <ion-label v-else-if="store.installmentSelected === 6">
                        <ion-icon
                            :icon="checkmarkCircleOutline"
                            color="success"
                            v-if="invoiceItem.sixthInstallment == 0"
                        />
                        {{ UtilMoney.formatValueToBrReturnStringCaseZero(invoiceItem.sixthInstallment) }}
                    </ion-label>
                </ion-col>
                <ion-col size="1" class="ion-text-end no-padding-end">
                    <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
