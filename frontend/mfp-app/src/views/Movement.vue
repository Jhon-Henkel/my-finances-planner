<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Movements</ion-title>
                <ion-buttons slot="end">
                    <ion-button @click="showCreateModal = true">
                        <ion-icon slot="icon-only" :icon="add"></ion-icon>
                    </ion-button>
                </ion-buttons>
            </ion-toolbar>
        </ion-header>
        <ion-content>
            <MovementList
                :movements="movements"
                @edit="handleEdit"
                @delete="handleDelete"
            />
            <ion-modal :is-open="showCreateModal" @didDismiss="showCreateModal = false">
                <MovementCreate @close="showCreateModal = false" @submit="handleCreate" />
            </ion-modal>
            <ion-modal :is-open="showEditModal" @didDismiss="showEditModal = false">
                <MovementEdit
                    v-if="selectedMovement"
                    :movement="selectedMovement"
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
import { useMovementStore } from '../stores/movement';
import MovementList from '../components/MovementList.vue';
import MovementCreate from '../components/MovementCreate.vue';
import MovementEdit from '../components/MovementEdit.vue';
import type { Movement } from '../types/movement';

const movementStore = useMovementStore();
const movements = computed(() => movementStore.movements);
const showCreateModal = ref(false);
const showEditModal = ref(false);
const selectedMovement = ref<Movement | null>(null);

onMounted(() => {
    movementStore.fetchMovements();
});

const handleCreate = async (movement: Movement) => {
    await movementStore.createMovement(movement);
    showCreateModal.value = false;
};

const handleEdit = (movement: Movement) => {
    selectedMovement.value = movement;
    showEditModal.value = true;
};

const handleUpdate = async (movement: Movement) => {
    await movementStore.updateMovement(movement);
    showEditModal.value = false;
};

const handleDelete = async (id: number) => {
    await movementStore.deleteMovement(id);
};
</script>
