<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import MfpFilterButton from "@/components/button/MfpFilterButton.vue"
import {IonCol, IonGrid, IonIcon, IonLabel, IonListHeader, IonRow} from "@ionic/vue"
import {useFinancialHealthStore} from "@/stores/financial-health/financialHealthStore"
import {onMounted} from "vue"
import MfpFinancialHealthValuesCard from "@/views/financial-health/MfpFinancialHealthValuesCard.vue"
import MfpFinancialHealthItemsList from "@/views/financial-health/MfpFinancialHealthItemsList.vue"
import {arrowDownCircleOutline, arrowUpCircleOutline} from "ionicons/icons"
import MfpFinancialHealthItemsListSkeletonLoad
    from "@/views/financial-health/MfpFinancialHealthItemsListSkeletonLoad.vue"
import MfpFinancialHealthMonthLabel from "@/views/financial-health/MfpFinancialHealthMonthLabel.vue"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpFinancialHealthFilterModal from "@/views/financial-health/MfpFinancialHealthFilterModal.vue"
import MfpFinancialHealthBalanceCard from "@/views/financial-health/MfpFinancialHealthBalanceCard.vue"
import MfpInfoButton from "@/components/button/MfpInfoButton.vue"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"

const store = useFinancialHealthStore()
const filterModal = new MfpModal(MfpFinancialHealthFilterModal)

function infoText() {
    const okAlert = new MfpOkAlert('Dica')
    okAlert.open(
        'Aqui é agrupado todas as descrições de movimentações, no caso de desagrupar o cartão de crédito, ' +
        'será exibido os itens das faturas referente a fatura paga nesse mesmo mês.'
    )
}

onMounted(() => {
    if (!store.isLoaded) {
        store.load()
    }
})
</script>

<template>
    <mfp-page>
        <ion-list-header>
            <ion-label>Saúde Financeira</ion-label>
            <mfp-info-button @click="infoText"/>
            <mfp-filter-button class="ion-margin-end" @click="filterModal.open()"/>
        </ion-list-header>
        <ion-grid>
            <mfp-financial-health-month-label/>
            <mfp-financial-health-values-card/>
            <mfp-financial-health-balance-card/>
            <ion-row>
                <ion-col>
                    <ion-list-header>
                        <ion-label class="center-ion-label-content">
                            <ion-icon :icon="arrowUpCircleOutline" class="ion-margin-end" color="success"/>
                            Receitas
                        </ion-label>
                    </ion-list-header>
                    <mfp-financial-health-items-list-skeleton-load v-if="! store.isLoaded"/>
                    <mfp-financial-health-items-list
                        :is-expense="false"
                        :total-value="store.items.incomeTotalAmount"
                        :items="store.items.incomeItens"
                        v-else
                    />
                    <ion-list-header>
                        <ion-label class="center-ion-label-content">
                            <ion-icon :icon="arrowDownCircleOutline" class="ion-margin-end" color="danger"/>
                            Despesas
                        </ion-label>
                    </ion-list-header>
                    <mfp-financial-health-items-list-skeleton-load v-if="! store.isLoaded"/>
                    <mfp-financial-health-items-list
                        :is-expense="true"
                        :total-value="store.items.expenseTotalAmount"
                        :items="store.items.expenseItens"
                        v-else
                    />
                </ion-col>
            </ion-row>
        </ion-grid>
    </mfp-page>
</template>
