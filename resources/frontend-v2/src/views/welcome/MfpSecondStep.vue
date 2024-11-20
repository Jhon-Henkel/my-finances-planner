<script setup lang="ts">
import {IonButton, IonCol, IonRow, IonText} from "@ionic/vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpMainSettingsModal from "@/views/settings/main/MfpMainSettingsModal.vue"
import MfpMainText from "@/views/welcome/MfpMainText.vue"

const emit = defineEmits(["next-step"])

async function openConfigModal() {
    const settingsModal = new MfpModal(MfpMainSettingsModal)
    await settingsModal.open()
    emit("next-step")
}
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="text-welcome"/>
        <ion-col size="1"/>
    </ion-row>
    <mfp-main-text/>
    <ion-row class="ion-margin-top">
        <ion-col size="1"/>
        <ion-col size="10">
            <ion-text>
                Agora, vamos definir as suas
                <ion-text color="primary">
                    <strong>
                        configurações gerais
                    </strong>
                </ion-text>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
    <ion-row class="ion-margin-top">
        <ion-col size="1"/>
        <ion-col size="10">
            <ion-button expand="block" @click="openConfigModal()">
                Configurações
            </ion-button>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>

<style scoped>
.text-welcome {
    margin-top: 50px;
    margin-bottom: 20px;
}

.finances-control-text {
    margin-bottom: 20px;
}

.text-1 {
    font-size: 1.5em;
}

.text-2 {
    font-size: 1em;
}
</style>
