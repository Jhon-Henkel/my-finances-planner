<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {IonButton, IonCol, IonGrid, IonRow, modalController, IonItem, IonList} from "@ionic/vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {MfpSubscriptionService} from "@/modules/subscription/service/MfpSubscriptionService"
import {useAuthStore} from "@/modules/login/store/AuthStore"
import {ref} from "vue"

const authStore = useAuthStore()
const actualPlan = authStore.user.plan
const subscribeButtonDisable = ref(false)
const cancelSubscriptionButtonDisable = ref(false)

function closeModal() {
    modalController.dismiss()
}

async function subscribe() {
    subscribeButtonDisable.value = true
    await MfpSubscriptionService.subscribeProPlan()
    subscribeButtonDisable.value = false
}

async function cancelSubscription() {
    cancelSubscriptionButtonDisable.value = true
    await MfpSubscriptionService.cancelProPlan()
    cancelSubscriptionButtonDisable.value = false
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
                        O pagamento é feito através do <strong>Stripe</strong>, é renovado automáticamente e pode ser cancelado a qualquer momento.
                    </p>
                </ion-item>
            </ion-list>
            <ion-grid>
                <ion-row v-show="actualPlan === 'Free'">
                    <ion-col>
                        <ion-button expand="block" @click="subscribe" v-if="!subscribeButtonDisable">
                            Assinar Plano Pro
                        </ion-button>
                        <ion-button expand="block" disabled v-else>
                            Gerando link de Pagamento, Aguarde...
                        </ion-button>
                    </ion-col>
                </ion-row>
                <ion-row>
                    <ion-col>
                        <ion-button expand="block" @click="cancelSubscription" color="danger" :disabled="actualPlan === 'Free'" v-if="!cancelSubscriptionButtonDisable">
                            Cancelar Assinatura
                        </ion-button>
                        <ion-button expand="block" @click="cancelSubscription" color="danger" disabled v-else>
                            Cancelando Assinatura, Aguarde...
                        </ion-button>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </template>
    </mfp-modal-content>
</template>
