<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Login</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <ion-item>
                <ion-label position="floating">Email</ion-label>
                <ion-input type="email" v-model="email"></ion-input>
            </ion-item>
            <ion-item>
                <ion-label position="floating">Password</ion-label>
                <ion-input type="password" v-model="password"></ion-input>
            </ion-item>
            <ion-button expand="full" @click="handleLogin">Login</ion-button>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonItem,
    IonLabel,
    IonInput,
    IonButton,
} from '@ionic/vue';
import { useAuthStore } from '../stores/auth';
import { useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const authStore = useAuthStore();
const router = useRouter();

const handleLogin = async () => {
    try {
        await authStore.login({ email: email.value, password: password.value });
        router.push('/');
    } catch (error) {
        console.error('Login failed:', error);
    }
};
</script>
