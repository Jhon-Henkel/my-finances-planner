<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Earning Plans</ion-title>
                <ion-buttons slot="end">
                    <ion-button @click="showCreateModal = true">
                        <ion-icon slot="icon-only" :icon="add"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        <ion-content>
            <EarningPlanList
                :earning-plans="earningPlans"
                @edit="handleEdit"
                @delete="handleDelete"
                @receive="handleReceive"
            />
            <ion-modal :is-open="showCreateModal" @didDismiss="showCreateModal = false">
                <EarningPlanCreate @close="showCreateModal = false" @submit="handleCreate" />
            </ion-modal>
            <ion-modal :is-open="showEditModal" @didDismiss="showEditModal = false">
                <EarningPlanEdit
                    v-if="selectedEarningPlan"
                    :earning-plan="selectedEarningPlan"
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
import { useEarningPlanStore } from '../stores/earningPlan';
import EarningPlanList from '../components/EarningPlanList.vue';
import EarningPlanCreate from '../components/EarningPlanCreate.vue';
import EarningPlanEdit from '../components/EarningPlanEdit.vue';
import type { EarningPlan } from '../types/earningPlan';

const earningPlanStore = useEarningPlanStore();
const earningPlans = computed(() => earningPlanStore.earningPlans);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedEarningPlan = ref<EarningPlan | null>(null);

onMounted(() => {
    earningPlanStore.fetchEarningPlans();
});

const handleCreate = async (earningPlan: EarningPlan) => {
    await earningPlanStore.createEarningPlan(earningPlan);
    showCreateModal.value = false;
};

const handleEdit = (earningPlan: EarningPlan) => {
    selectedEarningPlan.value = earningPlan;
    showEditModal.value = true;
};

const handleUpdate = async (earningPlan: EarningPlan) => {
    await earningPlanStore.updateEarningPlan(earningPlan);
    showEditModal.value = false;
};

const handleDelete = async (id: number) => {
    await earningPlanStore.deleteEarningPlan(id);
};

const handleReceive = async (id: number) => {
    await earningPlanStore.receiveEarningPlan(id);
};
</script>
