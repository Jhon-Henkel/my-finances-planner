<script setup lang="ts">
import {chevronForward} from "ionicons/icons"
import {IonIcon, IonCol, IonButton, IonRow, IonSpinner} from "@ionic/vue"

defineProps({
    loading: {
        type: Boolean,
        required: true
    }
})

const emits = defineEmits(['login-pressed'])

function submit() {
    emits('login-pressed')
}

</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="login-button">
            <ion-button expand="block" @click="submit" v-if="!loading">
                Entrar
                <ion-icon slot="end" :icon="chevronForward" class="animate-icon-right"/>
            </ion-button>
            <ion-button expand="block" v-else disabled>
                <ion-spinner name="crescent"/>
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