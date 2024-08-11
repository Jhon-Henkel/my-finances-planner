<script setup lang="ts">
import {chevronForward} from "ionicons/icons"
import {IonIcon, IonCol, IonButton, IonRow} from "@ionic/vue"

const emits = defineEmits(['registerPressed'])

function submit() {
    emits('registerPressed')
}
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="register-button">
            <ion-button expand="block" @click="submit">
                Registrar
                <ion-icon slot="end" :icon="chevronForward" class="animate-icon-right"/>
            </ion-button>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>

<style scoped>
.register-button {
    margin-top: 20px;
    margin-bottom: 20px;
}
</style>
