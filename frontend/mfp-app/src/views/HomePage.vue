<template>
    <ion-page>
        <ion-content :fullscreen="true" />
    </ion-page>
</template>

<script setup lang="ts">
import { IonContent, IonPage, onIonViewWillEnter } from '@ionic/vue';
import { useRouter } from 'vue-router';

const router = useRouter();

onIonViewWillEnter(() => {
    router.push('/wallets');
});
</script>
