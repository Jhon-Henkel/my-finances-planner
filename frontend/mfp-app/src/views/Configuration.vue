<template>
    <ion-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Configurations</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <ion-list>
                <ion-item v-for="config in configurations" :key="config.id">
                    <ion-label>{{ config.name }}</ion-label>
                    <ion-text>{{ config.value }}</ion-text>
                </ion-item>
            </ion-list>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue';
import {
    IonPage,
    IonHeader,
    IonToolbar,
    IonTitle,
    IonContent,
    IonList,
    IonItem,
    IonLabel,
    IonText,
} from '@ionic/vue';
import { useConfigurationStore } from '../stores/configuration';

const configurationStore = useConfigurationStore();
const configurations = computed(() => configurationStore.configurations);

onMounted(() => {
    configurationStore.fetchConfigurations();
});
</script>
