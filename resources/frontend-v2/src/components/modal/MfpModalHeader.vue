<script setup lang="ts">
import {IonButton, IonButtons, IonHeader, IonTitle, IonToolbar} from "@ionic/vue"

defineProps(
    {
        title: {
            type: String,
            required: true
        },
        saveActionLabel: {
            type: String,
            default: 'Salvar',
            required: false
        },
        saveActionButtonDisabled: {
            type: Boolean,
            default: false,
            required: false
        }
    }
)

const emits = defineEmits(['close-action', 'save-action'])
</script>

<template>
    <ion-header>
        <ion-toolbar>
            <ion-title>{{ title }}</ion-title>
            <ion-buttons slot="start">
                <ion-button @click="emits('close-action')">
                    Fechar
                </ion-button>
            </ion-buttons>
            <ion-buttons slot="end">
                <ion-button @click="emits('save-action')" :disabled="saveActionButtonDisabled">
                    {{ saveActionLabel }}
                </ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
</template>