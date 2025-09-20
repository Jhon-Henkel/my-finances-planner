<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>Edit Credit Card Invoice</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="emit('close')">Close</ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
        <ion-item>
            <ion-label>Credit Card</ion-label>
            <ion-select v-model="invoice.credit_card_id">
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
            <ion-label position="floating">Name</ion-label>
            <ion-input v-model="invoice.name"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Due Date</ion-label>
            <ion-input type="date" v-model="invoice.due_date"></ion-input>
        </ion-item>
        <ion-item>
            <ion-label position="floating">Closing Date</ion-label>
            <ion-input type="date" v-model="invoice.closing_date"></ion-input>
        </ion-item>
        <ion-button expand="full" @click="submit">Save</ion-button>
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
import { CreditCardInvoiceSchema, type CreditCardInvoice } from '../types/creditCardInvoice';
import { useCreditCardStore } from '../stores/creditCard';

const props = defineProps<{
    invoice: CreditCardInvoice;
}>();

const emit = defineEmits(['close', 'submit']);

const creditCardStore = useCreditCardStore();
const creditCards = computed(() => creditCardStore.creditCards);

onMounted(() => {
    creditCardStore.fetchCreditCards();
});

const invoice = reactive<CreditCardInvoice>({ ...props.invoice });

const submit = () => {
    try {
        const validatedInvoice = CreditCardInvoiceSchema.parse(invoice);
        emit('submit', validatedInvoice);
    } catch (error) {
        console.error('Validation error:', error);
    }
};
</script>
