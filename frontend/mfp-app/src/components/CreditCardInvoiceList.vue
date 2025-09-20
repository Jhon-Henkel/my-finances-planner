<template>
    <ion-list>
        <ion-item-group v-for="invoice in creditCardInvoices" :key="invoice.id">
            <ion-item-divider>
                <ion-label>
                    <h2>{{ invoice.name }}</h2>
                    <p>Due Date: {{ invoice.due_date }} | Closing Date: {{ invoice.closing_date }}</p>
                </ion-label>
                <ion-buttons slot="end">
                    <ion-button @click="$emit('edit', invoice)">
                        <ion-icon slot="icon-only" :icon="pencil"></ion-icon>
                    </ion-button>
                    <ion-button @click="$emit('delete', invoice.id)">
                        <ion-icon slot="icon-only" :icon="trash"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-item-divider>
            <ion-item v-for="item in invoice.items" :key="item.id">
                <ion-label>
                    <h3>{{ item.name }}</h3>
                    <p>Date: {{ item.date }} | Value: {{ item.value }}</p>
                </ion-label>
            </ion-item>
        </ion-item-group>
    </ion-list>
</template>

<script setup lang="ts">
import { IonList, IonItem, IonLabel, IonButtons, IonButton, IonIcon } from '@ionic/vue';
import { pencil, trash } from 'ionicons/icons';
import type { CreditCardInvoice } from '../types/creditCardInvoice';

defineProps<{
    creditCardInvoices: CreditCardInvoice[];
}>();

defineEmits(['edit', 'delete']);
</script>
