<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Financial Health</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <div v-if="financialHealth">
                <h2>Spending</h2>
                <DoughnutChart :chart-data="spendingData" />
                <h2>Gains</h2>
                <DoughnutChart :chart-data="gainsData" />
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent } from '@ionic/vue';
import { useFinancialHealthStore } from '../stores/financialHealth';
import { DoughnutChart } from 'vue-chart-3';
import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const financialHealthStore = useFinancialHealthStore();
const financialHealth = computed(() => financialHealthStore.financialHealth);

onMounted(() => {
    financialHealthStore.fetchFinancialHealth();
});

const spendingData = computed(() => {
    if (financialHealth.value && financialHealth.value.dataForGraph[5]) {
        return {
            labels: financialHealth.value.dataForGraph[5].label,
            datasets: [
                {
                    data: financialHealth.value.dataForGraph[5].data,
                    backgroundColor: financialHealth.value.dataForGraph[5].color,
                },
            ],
        };
    }
    return { labels: [], datasets: [] };
});

const gainsData = computed(() => {
    if (financialHealth.value && financialHealth.value.dataForGraph[6]) {
        return {
            labels: financialHealth.value.dataForGraph[6].label,
            datasets: [
                {
                    data: financialHealth.value.dataForGraph[6].data,
                    backgroundColor: financialHealth.value.dataForGraph[6].color,
                },
            ],
        };
    }
    return { labels: [], datasets: [] };
});
</script>
