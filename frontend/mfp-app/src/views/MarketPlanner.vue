<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Market Planner</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <div v-if="marketPlanner">
                <ion-item>
                    <ion-label>Use Market Planner:</ion-label>
                    <ion-text>{{ marketPlanner.use_market_planner ? 'Yes' : 'No' }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>Total Limit:</ion-label>
                    <ion-text>{{ marketPlanner.total_limit }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>This Month Spent:</ion-label>
                    <ion-text>{{ marketPlanner.this_month_spent }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>This Month Remaining Limit:</ion-label>
                    <ion-text>{{ marketPlanner.this_month_remaining_limit }}</ion-text>
                </ion-item>
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue';
import {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonItem,
    IonLabel,
    IonText,
} from '@ionic/vue';
import { useMarketPlannerStore } from '../stores/marketPlanner';

const marketPlannerStore = useMarketPlannerStore();
const marketPlanner = computed(() => marketPlannerStore.marketPlanner);

onMounted(() => {
    marketPlannerStore.fetchMarketPlanner();
});
</script>
