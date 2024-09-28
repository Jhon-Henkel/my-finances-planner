<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import {IonButton, IonContent, IonHeader, IonTitle, IonToolbar} from "@ionic/vue"
import router from "@/router"
</script>

<template>
    <mfp-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Assinatura Cancelada</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <div class="canceled-container">
                <h1>😢 Sentimos muito em ver você partir!</h1>
                <p>Esperamos que você volte em breve e aproveite todos os benefícios do nosso plano Pro.</p>
                <p>Você ainda terá acesso aos benefícios do plano Pro até o final desse ciclo de cobrança.</p>
                <ion-button expand="block" @click="router.push({name: 'dashboard'})">
                    Ir para o Dashboard
                </ion-button>
            </div>
        </ion-content>
    </mfp-page>
</template>

<style scoped>
.canceled-container {
    text-align: center;
    margin-top: 50px;
}

h1 {
    font-size: 24px;
    color: #b52e2e;
}

p {
    font-size: 18px;
    margin: 20px 0;
}
</style>
