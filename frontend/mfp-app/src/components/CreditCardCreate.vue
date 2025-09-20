<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Create Credit Card</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="$emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <ion-item>
            <ion-label position="floating">Name</ion-label>
            <ion-input v-model="creditCard.name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Limit</ion-label>
            <ion-input type="number" v-model.number="creditCard.limit"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Due Day</ion-label>
            <ion-input type="number" v-model.number="creditCard.due_day"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Closing Day</ion-label>
            <ion-input type="number" v-model.number="creditCard.closing_day"></ion-input>
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
} from '@ionic/vue';
import { CreditCardSchema, type CreditCard } from '../types/creditCard';

const emit = defineEmits(['close', 'submit']);

const creditCard = reactive<Partial<CreditCard>>({
    name: '',
    limit: 0,
    due_day: 1,
    closing_day: 1,
});

const submit = () => {
    try {
        const validatedCreditCard = CreditCardSchema.parse(creditCard);
        emit('submit', validatedCreditCard);
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
