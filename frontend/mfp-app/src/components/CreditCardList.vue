<template>
    <ion-list>
        <ion-item v-for="creditCard in creditCards" :key="creditCard.id">
            <ion-label>
                <h2>{{ creditCard.name }}</h2>
                <p>Limit: {{ creditCard.limit }}</p>
                <p>Due Day: {{ creditCard.due_day }}</p>
                <p>Closing Day: {{ creditCard.closing_day }}</p>
            </ion-label>
            <ion-buttons slot="end">
                <ion-button @click="$emit('edit', creditCard)">
                    <ion-icon slot="icon-only" :icon="pencil"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('delete', creditCard.id)">
                    <ion-icon slot="icon-only" :icon="trash"></ion-icon>
                </ion-button>
            </ion-buttons>
        </ion-item>
    </ion-list>
</template>

<script setup lang="ts">
import { IonList, IonItem, IonLabel, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { pencil, trash } from 'ionicons/icons';
import type { CreditCard } from '../types/creditCard';

defineProps<{
    creditCards: CreditCard[];
}>();

defineEmits(['edit', 'delete']);
</script>
