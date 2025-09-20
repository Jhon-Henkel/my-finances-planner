<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Create Wallet</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="$emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <ion-item>
            <ion-label position="floating">Name</ion-label>
            <ion-input v-model="wallet.name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Amount</ion-label>
            <ion-input type="number" v-model.number="wallet.amount"></ion-input>
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
import { WalletSchema, type Wallet } from '../types/wallet';

const emit = defineEmits(['close', 'submit']);

const wallet = reactive<Partial<Wallet>>({
    name: '',
    amount: 0,
});

const submit = () => {
    try {
        const validatedWallet = WalletSchema.parse(wallet);
        emit('submit', validatedWallet);
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
