<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Credit Card Invoices</ion-title>
                <ion-buttons slot="end">
                    <ion-button @click="showCreateModal = true">
                        <ion-icon slot="icon-only" :icon="add"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        <ion-content>
            <CreditCardInvoiceList
                :credit-card-invoices="creditCardInvoices"
                @edit="handleEdit"
                @delete="handleDelete"
            />
            <ion-modal :is-open="showCreateModal" @didDismiss="showCreateModal = false">
                <CreditCardInvoiceCreate @close="showCreateModal = false" @submit="handleCreate" />
            </ion-modal>
            <ion-modal :is-open="showEditModal" @didDismiss="showEditModal = false">
                <CreditCardInvoiceEdit
                    v-if="selectedCreditCardInvoice"
                    :invoice="selectedCreditCardInvoice"
                    @close="showEditModal = false"
                    @submit="handleUpdate"
                />
            </ion-modal>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonButtons,
    IonButton,
    IonIcon,
    IonModal,
} from '@ionic/vue';
import { add } from 'ionicons/icons';
import { useCreditCardInvoiceStore } from '../stores/creditCardInvoice';
import CreditCardInvoiceList from '../components/CreditCardInvoiceList.vue';
import CreditCardInvoiceCreate from '../components/CreditCardInvoiceCreate.vue';
import CreditCardInvoiceEdit from '../components/CreditCardInvoiceEdit.vue';
import type { CreditCardInvoice } from '../types/creditCardInvoice';

const creditCardInvoiceStore = useCreditCardInvoiceStore();
const creditCardInvoices = computed(() => creditCardInvoiceStore.creditCardInvoices);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedCreditCardInvoice = ref<CreditCardInvoice | null>(null);

onMounted(() => {
    creditCardInvoiceStore.fetchCreditCardInvoices();
});

const handleCreate = async (invoice: CreditCardInvoice) => {
    await creditCardInvoiceStore.createCreditCardInvoice(invoice);
    showCreateModal.value = false;
};

const handleEdit = (invoice: CreditCardInvoice) => {
    selectedCreditCardInvoice.value = invoice;
    showEditModal.value = true;
};

const handleUpdate = async (invoice: CreditCardInvoice) => {
    await creditCardInvoiceStore.updateCreditCardInvoice(invoice);
    showEditModal.value = false;
};

const handleDelete = async (id: number) => {
    await creditCardInvoiceStore.deleteCreditCardInvoice(id);
};
</script>
