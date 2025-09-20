<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Create Credit Card Invoice</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <h2>Invoice Details</h2>
        <ion-item>
            <ion-label>Credit Card</ion-label>
            <ion-select v-model="form.credit_card_id">
                <ion-select-option
                    v-for="creditCard in creditCards"
                    :key="creditCard.id"
                    :value="creditCard.id"
                >
                    {{ creditCard.name }}
                </ion-select-option>
            </ion-select>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Invoice Name</ion-label>
            <ion-input v-model="form.invoice_name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Due Date</ion-label>
            <ion-input type="date" v-model="form.due_date"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Closing Date</ion-label>
            <ion-input type="date" v-model="form.closing_date"></ion-input>
        </ion-item>

        <h2>Item Details</h2>
        <ion-item>
            <ion-label position="floating">Item Name</ion-label>
            <ion-input v-model="form.name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Value</ion-label>
            <ion-input type="number" v-model.number="form.value"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Date</ion-label>
            <ion-input type="date" v-model="form.date"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label>Fixed</ion-label>
            <ion-toggle v-model="form.is_fixed"></ion-toggle>
        </ion-item>
        <ion-item v-if="!form.is_fixed">
            <ion-label position="floating">Installments</ion-label>
            <ion-input type="number" v-model.number="form.installments"></ion-input>
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
    IonToggle,
} from '@ionic/vue';
import { z } from 'zod';
import { useCreditCardStore } from '../stores/creditCard';
import { useCreditCardInvoiceItemStore } from '../stores/creditCardInvoiceItem';

const emit = defineEmits(['close', 'submit']);

const creditCardStore = useCreditCardStore();
const creditCardInvoiceItemStore = useCreditCardInvoiceItemStore();
const creditCards = computed(() => creditCardStore.creditCards);

onMounted(() => {
    creditCardStore.fetchCreditCards();
});

const FormSchema = z.object({
    credit_card_id: z.number(),
    invoice_name: z.string(),
    due_date: z.string(),
    closing_date: z.string(),
    name: z.string(),
    value: z.number(),
    date: z.string(),
    is_fixed: z.boolean(),
    installments: z.number().optional(),
});

const form = reactive({
    credit_card_id: undefined,
    invoice_name: '',
    due_date: new Date().toISOString().split('T')[0],
    closing_date: new Date().toISOString().split('T')[0],
    name: '',
    value: 0,
    date: new Date().toISOString().split('T')[0],
    is_fixed: true,
    installments: 1,
});

const submit = async () => {
    try {
        const validatedForm = FormSchema.parse(form);
        await creditCardInvoiceItemStore.createCreditCardInvoiceWithItem(validatedForm);
        emit('submit');
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
