<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Edit Spending Plan</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="$emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <ion-item>
            <ion-label position="floating">Name</ion-label>
            <ion-input v-model="spendingPlan.name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Amount</ion-label>
            <ion-input type="number" v-model.number="spendingPlan.amount"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>Fixed</ion-label>
            <ion-toggle v-model="spendingPlan.isFixed"></ion-toggle>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Installments</ion-label>
            <ion-input type="number" v-model.number="spendingPlan.installments"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Recurrence</ion-label>
            <ion-input type="number" v-model.number="spendingPlan.recurrence"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Due Date</ion-label>
            <ion-input type="date" v-model="spendingPlan.dueDate"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Bank Slip Code</ion-label>
            <ion-input v-model="spendingPlan.bankSlipCode"></ion-input>
        </ion-item>
        <ion-button expand="full" @click="submit">Save</ion-button>
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
import { SpendingPlanSchema, type SpendingPlan } from '../types/spendingPlan';

const props = defineProps<{
    spendingPlan: SpendingPlan;
}>();

const emit = defineEmits(['close', 'submit']);

const spendingPlan = reactive<SpendingPlan>({ ...props.spendingPlan });

const submit = () => {
    try {
        const validatedSpendingPlan = SpendingPlanSchema.parse(spendingPlan);
        emit('submit', validatedSpendingPlan);
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
