<template>
    <ion-list>
        <ion-item v-for="earningPlan in earningPlans" :key="earningPlan.id">
            <ion-label>
                <h2>{{ earningPlan.name }}</h2>
                <p>Amount: {{ earningPlan.amount }}</p>
                <p>Due Date: {{ earningPlan.dueDate }}</p>
            </ion-label>
            <ion-buttons slot="end">
                <ion-button @click="$emit('edit', earningPlan)">
                    <ion-icon slot="icon-only" :icon="pencil"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('delete', earningPlan.id)">
                    <ion-icon slot="icon-only" :icon="trash"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('receive', earningPlan.id)">
                    <ion-icon slot="icon-only" :icon="cash"></ion-icon>
                </ion-button>
            </ion-buttons>
        </ion-item>
    </ion-list>
</template>

<script setup lang="ts">
import { IonList, IonItem, IonLabel, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { pencil, trash, cash } from 'ionicons/icons';
import type { EarningPlan } from '../types/earningPlan';

defineProps<{
    earningPlans: EarningPlan[];
}>();

defineEmits(['edit', 'delete', 'receive']);
</script>
