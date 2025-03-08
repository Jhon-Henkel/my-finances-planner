<script setup lang="ts">
import {IonButton, IonButtons, IonHeader, IonTitle, IonToolbar} from "@ionic/vue"
import {ref, watch} from "vue"

const props = defineProps(
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
        },
        saveActionHidden: {
            type: Boolean,
            default: false,
            required: false
        }
    }
)

const emits = defineEmits(['close-action', 'save-action'])
const isButtonDisabled = ref(props.saveActionButtonDisabled);

function saveAction() {
    emits('save-action')
    isButtonDisabled.value = true
}

watch(() => props.saveActionButtonDisabled, (newVal) => {
    isButtonDisabled.value = newVal;
});
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
            <ion-buttons slot="end" v-if="!saveActionHidden">
                <ion-button @click="saveAction" :disabled="isButtonDisabled">
                    {{ saveActionLabel }}
                </ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
</template>
