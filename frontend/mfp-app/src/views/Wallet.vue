<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Wallets</ion-title>
                <ion-buttons slot="end">
                    <ion-button @click="showCreateModal = true">
                        <ion-icon slot="icon-only" :icon="add"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        <ion-content>
            <WalletList
                :wallets="wallets"
                @edit="handleEdit"
                @delete="handleDelete"
            />
            <ion-modal :is-open="showCreateModal" @didDismiss="showCreateModal = false">
                <WalletCreate @close="showCreateModal = false" @submit="handleCreate" />
            </ion-modal>
            <ion-modal :is-open="showEditModal" @didDismiss="showEditModal = false">
                <WalletEdit
                    v-if="selectedWallet"
                    :wallet="selectedWallet"
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
import { useWalletStore } from '../stores/wallet';
import WalletList from '../components/WalletList.vue';
import WalletCreate from '../components/WalletCreate.vue';
import WalletEdit from '../components/WalletEdit.vue';
import type { Wallet } from '../types/wallet';

const walletStore = useWalletStore();
const wallets = computed(() => walletStore.wallets);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedWallet = ref<Wallet | null>(null);

onMounted(() => {
    walletStore.fetchWallets();
});

const handleCreate = async (wallet: Wallet) => {
    await walletStore.createWallet(wallet);
    showCreateModal.value = false;
};

const handleEdit = (wallet: Wallet) => {
    selectedWallet.value = wallet;
    showEditModal.value = true;
};

const handleUpdate = async (wallet: Wallet) => {
    await walletStore.updateWallet(wallet);
    showEditModal.value = false;
};

const handleDelete = async (id: number) => {
    await walletStore.deleteWallet(id);
};
</script>
