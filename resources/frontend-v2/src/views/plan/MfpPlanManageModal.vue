<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import {IonButton, IonCol, IonGrid, IonRow, modalController, IonItem, IonList} from "@ionic/vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {MfpSubscriptionService} from "@/services/subscription/MfpSubscriptionService"
import {useAuthStore} from "@/stores/auth/AuthStore"

const authStore = useAuthStore()
const actualPlan = authStore.user.plan

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Gerenciar Plano" :saveActionHidden="true" @close-action="closeModal"/>
    <mfp-modal-content>
        <template #list>
            <ion-item color="light">
                <p>Plano atual: {{ actualPlan }}</p>
            </ion-item>
        </template>
        <template #footer>
            <ion-list :inset="true">
                <ion-item color="light">
                    <p>
                        No Plano free você tem limitação de cadastro de carteiras e de cartões de crédito, também não
                        tem acesso a funcionalidade de Saúde Financeira.
                        <br>
                        <br>
                        No Plano Pro você paga <strong>R$ 9,90</strong> por mês e tem acesso a todos os recursos do aplicativo.
                        <br>
                        <br>
                        O pagamento é feito através do <strong>Stripe</strong> e pode ser cancelado a qualquer momento.
                    </p>
                </ion-item>
            </ion-list>
            <ion-grid>
                <ion-row v-show="actualPlan === 'Free'">
                    <ion-col>
                        <ion-button expand="block" @click="MfpSubscriptionService.subscribeProPlan()">
                            Assinar Plano Pro
                        </ion-button>
                    </ion-col>
                </ion-row>
                <ion-row>
                    <ion-col>
                        <ion-button expand="block" @click="MfpSubscriptionService.syncSubscription(authStore.user.email)">
                            Sincronizar Assinatura
                        </ion-button>
                    </ion-col>
                </ion-row>
                <ion-row v-show="actualPlan === 'Pro'">
                    <ion-col>
                        <ion-button expand="block" @click="MfpSubscriptionService.cancelProPlan(authStore.user.email)" color="danger">
                            Cancelar Assinatura
                        </ion-button>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </template>
    </mfp-modal-content>
</template>
