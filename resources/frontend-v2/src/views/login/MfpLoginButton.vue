<script setup lang="ts">
import {chevronForward} from "ionicons/icons"
import {IonIcon, IonCol, IonButton, IonRow} from "@ionic/vue"

const emits = defineEmits(['login-pressed'])

function submit() {
    emits('login-pressed')
}

</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="login-button">
            <ion-button expand="block" @click="submit">
                Entrar
                <ion-icon slot="end" :icon="chevronForward" class="animate-icon-right"/>
            </ion-button>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>

<style scoped>
.login-button {
    margin-top: 20px;
    margin-bottom: 20px;
}
</style>