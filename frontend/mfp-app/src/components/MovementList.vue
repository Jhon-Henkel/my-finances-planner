<template>
    <ion-list>
        <ion-item v-for="movement in movements" :key="movement.id">
            <ion-label>
                <h2>{{ movement.description }}</h2>
                <p>Amount: {{ movement.amount }}</p>
                <p>Type: {{ movement.type }}</p>
            </ion-label>
            <ion-buttons slot="end">
                <ion-button @click="$emit('edit', movement)">
                    <ion-icon slot="icon-only" :icon="pencil"></ion-icon>
                </ion-button>
                <ion-button @click="$emit('delete', movement.id)">
                    <ion-icon slot="icon-only" :icon="trash"></ion-icon>
                </ion-button>
            </ion-buttons>
        </ion-item>
    </ion-list>
</template>

<script setup lang="ts">
import { IonList, IonItem, IonLabel, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { pencil, trash } from 'ionicons/icons';
import type { Movement } from '../types/movement';

defineProps<{
    movements: Movement[];
}>();

defineEmits(['edit', 'delete']);
</script>
