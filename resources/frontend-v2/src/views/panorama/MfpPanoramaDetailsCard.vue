<script setup lang="ts">
import {IonGrid} from "@ionic/vue"
import {arrowDownOutline, arrowForwardOutline, arrowUpOutline, cardOutline, walletOutline} from "ionicons/icons"
import MfpAccordionGroup from "@/modules/@shared/components/accordion/MfpAccordionGroup.vue"
import MfpAccordion from "@/modules/@shared/components/accordion/MfpAccordion.vue"
import MfpPanoramaDetailsCardItem from "@/views/panorama/MfpPanoramaDetailsCardItem.vue"
import {usePanoramaStore} from "@/stores/panorama/PanoramaStore"
import {IInvoice} from "@/services/invoice/IInvoice"
import {ref} from "vue"

const store = usePanoramaStore()
const totalExpenses = ref(0)

function makeValueForExpenses(installmentSelected: number): number {
    let total = 0
    if (installmentSelected == 1) {
        store.panorama.futureExpenses.forEach((item) => {
            total = total + item.firstInstallment
        })
    } else if (installmentSelected == 2) {
        store.panorama.futureExpenses.forEach((item) => {
            total = total + item.secondInstallment
        })
    } else if (installmentSelected == 3) {
        store.panorama.futureExpenses.forEach((item) => {
            total = total + item.thirdInstallment
        })
    } else if (installmentSelected == 4) {
        store.panorama.futureExpenses.forEach((item) => {
            total = total + item.fourthInstallment
        })
    } else if (installmentSelected == 5) {
        store.panorama.futureExpenses.forEach((item) => {
            total = total + item.fifthInstallment
        })
    } else if (installmentSelected == 6) {
        store.panorama.futureExpenses.forEach((item) => {
            total = total + item.sixthInstallment
        })
    }
    totalExpenses.value = total
    return total
}

function MakeValueForIInvoice(installmentSelected: number, item: IInvoice|undefined): number {
    let total = 0
    if (item === undefined) {
        return 0
    }
    if (installmentSelected == 1) {
        total = item.firstInstallment
    } else if (installmentSelected == 2) {
        total = item.secondInstallment
    } else if (installmentSelected == 3) {
        total = item.thirdInstallment
    } else if (installmentSelected == 4) {
        total = item.fourthInstallment
    } else if (installmentSelected == 5) {
        total = item.fifthInstallment
    } else if (installmentSelected == 6) {
        total = item.sixthInstallment
    }
    return total
}

function makeSumOfAllValues(installmentSelected: number): number {
    const totalGain = MakeValueForIInvoice(installmentSelected, store.panorama.totalFutureGains)
    const totalCard = MakeValueForIInvoice(installmentSelected, store.panorama.totalCreditCardExpenses)
    let totalWallet = 0
    if (store.installmentSelected === 1) {
        totalWallet = store.panorama.totalWalletValue
    }
    return (totalGain + totalWallet) - (totalExpenses.value + totalCard)
}
</script>

<template>
    <mfp-accordion-group>
        <mfp-accordion title="Detalhes" value="first">
            <ion-grid>
                <mfp-panorama-details-card-item
                    title="Gastos"
                    icon-color="danger"
                    :icon="arrowDownOutline"
                    :value="makeValueForExpenses(store.installmentSelected)"
                />
                <mfp-panorama-details-card-item
                    title="Cartões"
                    icon-color="warning"
                    :icon="cardOutline"
                    :value=" MakeValueForIInvoice(store.installmentSelected, store.panorama.totalCreditCardExpenses)"
                />
                <mfp-panorama-details-card-item
                    title="Ganhos"
                    icon-color="success"
                    :icon="arrowUpOutline"
                    :value="MakeValueForIInvoice(store.installmentSelected, store.panorama.totalFutureGains)"
                />
                <mfp-panorama-details-card-item
                    title="Carteira"
                    icon-color="tertiary"
                    :icon="walletOutline"
                    :value="store.installmentSelected === 1 ? store.panorama.totalWalletValue ?? '-' : '-'"
                />
                <mfp-panorama-details-card-item
                    title="Sobras"
                    icon-color="primary"
                    :icon="arrowForwardOutline"
                    :value="makeSumOfAllValues(store.installmentSelected)"
                    :use-badge="true"
                />
            </ion-grid>
        </mfp-accordion>
    </mfp-accordion-group>
</template>
