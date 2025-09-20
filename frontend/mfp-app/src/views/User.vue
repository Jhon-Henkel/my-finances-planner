<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>User Profile</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <div v-if="user">
                <ion-item>
                    <ion-label>Name:</ion-label>
                    <ion-text>{{ user.name }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>Email:</ion-label>
                    <ion-text>{{ user.email }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>Status:</ion-label>
                    <ion-text>{{ user.status === 1 ? 'Active' : 'Inactive' }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>Email Verified At:</ion-label>
                    <ion-text>{{ user.email_verified_at }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>Created At:</ion-label>
                    <ion-text>{{ user.created_at }}</ion-text>
                </ion-item>
                <ion-item>
                    <ion-label>Updated At:</ion-label>
                    <ion-text>{{ user.updated_at }}</ion-text>
                </ion-item>
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue';
import { IonPage, IonHeader, IonToolbar, IonTitle, IonContent, IonItem, IonLabel, IonText } from '@ionic/vue';
import { useUserStore } from '../stores/user';
import { useAuthStore } from '../stores/auth';

const userStore = useUserStore();
const authStore = useAuthStore();
const user = computed(() => userStore.user);

onMounted(() => {
    if (authStore.user) {
        userStore.fetchUser(authStore.user.id);
    }
});
</script>
