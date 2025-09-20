<template>
    <ion-list>
        <ion-item v-for="spendingPlan in spendingPlans" :key="spendingPlan.id">
            <ion-label>
                <h2>{{ spendingPlan.name }}</h2>
                <p>Amount: {{ spendingPlan.amount }}</p>
                <p>Due Date: {{ spendingPlan.dueDate }}</p>
            </ion-label>
            <ion-buttons slot="end">
                <ion-button @click="$emit('edit', spendingPlan)">
                    <ion-icon slot="icon-only" :icon="pencil"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('delete', spendingPlan.id)">
                    <ion-icon slot="icon-only" :icon="trash"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('pay', spendingPlan.id)">
                    <ion-icon slot="icon-only" :icon="card"></ion-icon>
                </ion-button>
            </ion-buttons>
        </ion-item>
    </ion-list>
</template>

<script setup lang="ts">
import { IonList, IonItem, IonLabel, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { pencil, trash, card } from 'ionicons/icons';
import type { SpendingPlan } from '../types/spendingPlan';

defineProps<{
    spendingPlans: SpendingPlan[];
}>();

defineEmits(['edit', 'delete', 'pay']);
</script>
