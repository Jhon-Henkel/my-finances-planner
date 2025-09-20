<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Create Earning Plan</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <ion-item>
            <ion-label position="floating">Name</ion-label>
            <ion-input v-model="earningPlan.name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Amount</ion-label>
            <ion-input type="number" v-model.number="earningPlan.amount"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>Fixed</ion-label>
            <ion-toggle v-model="earningPlan.isFixed"></ion-toggle>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Installments</ion-label>
            <ion-input type="number" v-model.number="earningPlan.installments"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Recurrence</ion-label>
            <ion-input type="number" v-model.number="earningPlan.recurrence"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Due Date</ion-label>
            <ion-input type="date" v-model="earningPlan.dueDate"></ion-input>
        </ion-item>
        <ion-button expand="full" @click="submit">Create</ion-button>
    </ion-content>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import {
    IonHeader,
    IonToolbar,
    IonTitle,
    IonButtons,
    IonButton,
    IonContent,
    IonItem,
    IonLabel,
    IonInput,
    IonToggle,
} from '@ionic/vue';
import { EarningPlanSchema, type EarningPlan } from '../types/earningPlan';

const emit = defineEmits(['close', 'submit']);

const earningPlan = reactive<Partial<EarningPlan>>({
    name: '',
    amount: 0,
    isFixed: false,
    installments: 1,
    recurrence: 1,
    dueDate: new Date().toISOString().split('T')[0],
});

const submit = () => {
    try {
        const validatedEarningPlan = EarningPlanSchema.parse(earningPlan);
        emit('submit', validatedEarningPlan);
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
