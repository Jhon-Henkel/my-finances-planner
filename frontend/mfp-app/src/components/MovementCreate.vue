<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Create Movement</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="$emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <ion-item>
            <ion-label position="floating">Description</ion-label>
            <ion-input v-model="movement.description"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Amount</ion-label>
            <ion-input type="number" v-model.number="movement.amount"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>Type</ion-label>
            <ion-select v-model="movement.type">
                <ion-select-option value="5">Spent</ion-select-option>
                <ion-select-option value="6">Gain</ion-select-option>
            </ion-select>
        </ion-item>
        <ion-item>
            <ion-label>Wallet</ion-label>
            <ion-select v-model="movement.walletId">
                <ion-select-option
                    v-for="wallet in wallets"
                    :key="wallet.id"
                    :value="wallet.id"
                >
                    {{ wallet.name }}
                </ion-select-option>
            </ion-select>
        </ion-item>
        <ion-button expand="full" @click="submit">Create</ion-button>
    </ion-content>
</template>

<script setup lang="ts">
import { reactive, onMounted, computed } from 'vue';
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
    IonSelect,
    IonSelectOption,
} from '@ionic/vue';
import { MovementSchema, type Movement } from '../types/movement';
import { useWalletStore } from '../stores/wallet';

const emit = defineEmits(['close', 'submit']);

const walletStore = useWalletStore();
const wallets = computed(() => walletStore.wallets);

onMounted(() => {
    walletStore.fetchWallets();
});

const movement = reactive<Partial<Movement>>({
    description: '',
    amount: 0,
    type: '5',
    walletId: undefined,
});

const submit = () => {
    try {
        const validatedMovement = MovementSchema.parse(movement);
        emit('submit', validatedMovement);
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
