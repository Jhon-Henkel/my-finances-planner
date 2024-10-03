<script setup lang="ts">
import {IonCard, IonCardSubtitle, IonCol, IonRow} from '@ionic/vue'
import {useWalletStore} from "@/stores/wallet/WalletStore"
import {onMounted} from "vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"

const walletStore = useWalletStore()

onMounted(async () => {
    if (!walletStore.isLoaded) {
        await walletStore.getWallets
    }
})
</script>

<template>
    <ion-row>
        <ion-col>
            <ion-card color="light" class="ion-no-margin ion-text-center">
                <ion-row class="ion-margin">
                    <ion-col size="12">
                        <ion-card-subtitle>Saldo Carteiras</ion-card-subtitle>
                        <mfp-counter-money :end="walletStore.getTotalAmount"/>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
