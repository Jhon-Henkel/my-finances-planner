<template>
    <ion-list>
        <ion-item v-for="wallet in wallets" :key="wallet.id">
            <ion-label>
                <h2>{{ wallet.name }}</h2>
                <p>{{ wallet.amount }}</p>
            </ion-label>
            <ion-buttons slot="end">
                <ion-button @click="$emit('edit', wallet)">
                    <ion-icon slot="icon-only" :icon="pencil"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('delete', wallet.id)">
                    <ion-icon slot="icon-only" :icon="trash"></ion-icon>
                </ion-button>
            </ion-buttons>
        </ion-item>
    </ion-list>
</template>

<script setup lang="ts">
import { IonList, IonItem, IonLabel, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { pencil, trash } from 'ionicons/icons';
import type { Wallet } from '../types/wallet';

defineProps<{
    wallets: Wallet[];
}>();

defineEmits(['edit', 'delete']);
</script>
