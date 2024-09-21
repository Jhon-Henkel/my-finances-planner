<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import router from "@/router"
import {
    IonButton,
    IonCard,
    IonCardContent,
    IonCardHeader,
    IonCardTitle,
    IonContent,
    IonHeader,
    IonTitle,
    IonToolbar
} from "@ionic/vue"
import {MfpSubscriptionService} from "@/services/subscription/MfpSubscriptionService"

const urlParams = new URLSearchParams(window.location.search)
const email = urlParams.get('email') ?? ''

MfpSubscriptionService.syncSubscription(email)
</script>

<template>
    <mfp-page>
        <ion-header>
            <ion-toolbar>
                <ion-title>Bem-vindo ao Plano Pro!</ion-title>
            </ion-toolbar>
        </ion-header>
        <ion-content class="ion-padding">
            <div class="welcome-container">
                <h1>🎉 Obrigado por se tornar um usuário Pro! 🎉</h1>
                <p>Aproveite todos os benefícios exclusivos do nosso plano <strong>Pro</strong> agora.</p>
                <ion-card>
                    <ion-card-header>
                        <ion-card-title>Benefícios do Plano Pro</ion-card-title>
                    </ion-card-header>
                    <ion-card-content>
                        <p>
                            - Acesso a todos os recursos do aplicativo
                            <br>
                            - Sem limitações de cadastro de carteiras e cartões
                            <br>
                            - Relatório de Saúde Financeira
                        </p>
                    </ion-card-content>
                </ion-card>
                <ion-button expand="block" @click="router.push({name: 'dashboard'})">
                    Ir para o Dashboard
                </ion-button>
            </div>
        </ion-content>
    </mfp-page>
</template>

<style scoped>
.welcome-container {
    text-align: center;
    margin-top: 50px;
}

h1 {
    font-size: 24px;
    color: #3880ff;
}

p {
    font-size: 18px;
    margin: 20px 0;
}
</style>
