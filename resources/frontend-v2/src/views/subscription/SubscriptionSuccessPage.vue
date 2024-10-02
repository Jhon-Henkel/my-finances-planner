<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import router from "@/router"
import {IonButton, IonCard, IonCardContent, IonCardHeader, IonCardTitle, IonRow, IonCol, IonGrid} from "@ionic/vue"
import {useAuthStore} from "@/stores/auth/AuthStore"

const store = useAuthStore()
store.logout()

</script>

<template>
    <mfp-page>
        <div class="welcome-container">
            <h1>Obrigado por se tornar um usuário Pro! 🎉</h1>
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
            <ion-card>
                <ion-card-content>
                    <p>
                        Caso ainda não reconheça como plano Pro ao fazer login, aguarde, pode levar até 24 horas
                        para instituição de pagamento nos notificar.
                    </p>
                </ion-card-content>
            </ion-card>
        </div>
        <ion-grid>
            <ion-row>
                <ion-col>
                    <ion-button expand="block" @click="router.push({name: 'dashboard'})" class="">
                        Fazer Login
                    </ion-button>
                </ion-col>
            </ion-row>
        </ion-grid>
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
