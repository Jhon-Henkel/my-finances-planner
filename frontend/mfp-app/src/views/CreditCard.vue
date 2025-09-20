<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Credit Cards</ion-title>
                <ion-buttons slot="end">
                    <ion-button @click="showCreateModal = true">
                        <ion-icon slot="icon-only" :icon="add"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        <ion-content>
            <CreditCardList
                :credit-cards="creditCards"
                @edit="handleEdit"
                @delete="handleDelete"
            />
            <ion-modal :is-open="showCreateModal" @didDismiss="showCreateModal = false">
                <CreditCardCreate @close="showCreateModal = false" @submit="handleCreate" />
            </ion-modal>
            <ion-modal :is-open="showEditModal" @didDismiss="showEditModal = false">
                <CreditCardEdit
                    v-if="selectedCreditCard"
                    :credit-card="selectedCreditCard"
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
import { useCreditCardStore } from '../stores/creditCard';
import CreditCardList from '../components/CreditCardList.vue';
import CreditCardCreate from '../components/CreditCardCreate.vue';
import CreditCardEdit from '../components/CreditCardEdit.vue';
import type { CreditCard } from '../types/creditCard';

const creditCardStore = useCreditCardStore();
const creditCards = computed(() => creditCardStore.creditCards);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedCreditCard = ref<CreditCard | null>(null);

onMounted(() => {
    creditCardStore.fetchCreditCards();
});

const handleCreate = async (creditCard: CreditCard) => {
    await creditCardStore.createCreditCard(creditCard);
    showCreateModal.value = false;
};

const handleEdit = (creditCard: CreditCard) => {
    selectedCreditCard.value = creditCard;
    showEditModal.value = true;
};

const handleUpdate = async (creditCard: CreditCard) => {
    await creditCardStore.updateCreditCard(creditCard);
    showEditModal.value = false;
};

const handleDelete = async (id: number) => {
    await creditCardStore.deleteCreditCard(id);
};
</script>
