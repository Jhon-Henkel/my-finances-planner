<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Spending Plans</ion-title>
                <ion-buttons slot="end">
                    <ion-button @click="showCreateModal = true">
                        <ion-icon slot="icon-only" :icon="add"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        <ion-content>
            <SpendingPlanList
                :spending-plans="spendingPlans"
                @edit="handleEdit"
                @delete="handleDelete"
                @pay="handlePay"
            />
            <ion-modal :is-open="showCreateModal" @didDismiss="showCreateModal = false">
                <SpendingPlanCreate @close="showCreateModal = false" @submit="handleCreate" />
            </ion-modal>
            <ion-modal :is-open="showEditModal" @didDismiss="showEditModal = false">
                <SpendingPlanEdit
                    v-if="selectedSpendingPlan"
                    :spending-plan="selectedSpendingPlan"
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
import { useSpendingPlanStore } from '../stores/spendingPlan';
import SpendingPlanList from '../components/SpendingPlanList.vue';
import SpendingPlanCreate from '../components/SpendingPlanCreate.vue';
import SpendingPlanEdit from '../components/SpendingPlanEdit.vue';
import type { SpendingPlan } from '../types/spendingPlan';

const spendingPlanStore = useSpendingPlanStore();
const spendingPlans = computed(() => spendingPlanStore.spendingPlans);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedSpendingPlan = ref<SpendingPlan | null>(null);

onMounted(() => {
    spendingPlanStore.fetchSpendingPlans();
});

const handleCreate = async (spendingPlan: SpendingPlan) => {
    await spendingPlanStore.createSpendingPlan(spendingPlan);
    showCreateModal.value = false;
};

const handleEdit = (spendingPlan: SpendingPlan) => {
    selectedSpendingPlan.value = spendingPlan;
    showEditModal.value = true;
};

const handleUpdate = async (spendingPlan: SpendingPlan) => {
    await spendingPlanStore.updateSpendingPlan(spendingPlan);
    showEditModal.value = false;
};

const handleDelete = async (id: number) => {
    await spendingPlanStore.deleteSpendingPlan(id);
};

const handlePay = async (id: number) => {
    await spendingPlanStore.paySpendingPlan(id);
};
</script>
