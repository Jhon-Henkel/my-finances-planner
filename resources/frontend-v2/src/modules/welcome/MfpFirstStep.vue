<script setup lang="ts">
import {IonCol, IonRow, IonText, IonButton} from "@ionic/vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpWalletsFormModal from "@/modules/wallet/component/MfpWalletsFormModal.vue"
import MfpMainText from "@/modules/welcome/MfpMainText.vue"

const emit = defineEmits(["next-step"])

async function openWalletModal() {
    const walletModal = new MfpModal(MfpWalletsFormModal)
    await walletModal.open()
    emit("next-step")
}
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="text-welcome">
            <ion-text color="primary">
                <h1>
                    <strong>
                        Bem Vindo!
                    </strong>
                </h1>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
    <mfp-main-text/>
    <ion-row class="ion-margin-top">
        <ion-col size="1"/>
        <ion-col size="10">
            <ion-text>
                Vamos começar criando uma
                <ion-text color="primary">
                    <strong>
                        carteira
                    </strong>
                </ion-text>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
    <ion-row class="ion-margin-top">
        <ion-col size="1"/>
        <ion-col size="10">
            <ion-button expand="block" @click="openWalletModal()">
                Criar Carteira
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
</style>
