<script setup lang="ts">
import {IonGrid} from "@ionic/vue"
import {arrowDownOutline, arrowForwardOutline, arrowUpOutline, cardOutline, walletOutline} from "ionicons/icons"
import MfpAccordionGroup from "@/modules/@shared/components/accordion/MfpAccordionGroup.vue"
import MfpAccordion from "@/modules/@shared/components/accordion/MfpAccordion.vue"
import MfpSpendingPlanDetailsCardItem from "@/modules/spending-plan/component/MfpSpendingPlanDetailsCardItem.vue"

const props = defineProps(
    {
        store: {
            type: Object,
            required: true
        }
    }
)

function makeSumOfAllValues(): number {
    const earnings = props.store.earningsTotalAmount + props.store.walletTotalAmount
    const spending = props.store.monthTotalAmount + props.store.creditCardsTotalAmount
    return earnings - spending
}
</script>

<template>
    <mfp-accordion-group>
        <mfp-accordion title="Detalhes" value="first">
            <ion-grid>
                <mfp-spending-plan-details-card-item
                    title="Gastos"
                    icon-color="danger"
                    :icon="arrowDownOutline"
                    :value="store.monthTotalAmount"
                />
                <mfp-spending-plan-details-card-item
                    title="Cartões"
                    icon-color="warning"
                    :icon="cardOutline"
                    :value="store.creditCardsTotalAmount"
                />
                <mfp-spending-plan-details-card-item
                    title="Ganhos"
                    icon-color="success"
                    :icon="arrowUpOutline"
                    :value="store.earningsTotalAmount"
                />
                <mfp-spending-plan-details-card-item
                    title="Carteira"
                    icon-color="tertiary"
                    :icon="walletOutline"
                    :value="store.walletTotalAmount == 0 ? '-' : store.walletTotalAmount"
                />
                <mfp-spending-plan-details-card-item
                    title="Sobras"
                    icon-color="primary"
                    :icon="arrowForwardOutline"
                    :value="makeSumOfAllValues()"
                    :use-badge="true"
                />
            </ion-grid>
        </mfp-accordion>
    </mfp-accordion-group>
</template>
