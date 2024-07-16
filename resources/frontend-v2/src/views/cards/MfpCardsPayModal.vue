<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {IonLabel, modalController, IonIcon, IonCol, IonRow} from "@ionic/vue"
import MfpWalletSelect from "@/components/select/MfpWalletSelect.vue"
import {PropType, ref} from "vue"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {CardModel} from "@/model/card/CardModel"
import {UtilMoney} from "@/util/UtilMoney"
import {ApiRouter} from "@/api/ApiRouter"
import {alertCircleOutline} from "ionicons/icons"
import {CardsPayFormValidation} from "@/form-validation/cards/CardsPayFormValidation"
import {MfpToast} from "@/components/toast/MfpToast"
import {CardsService} from "@/services/cards/CardsService"
import {MovementService} from "@/services/movement/MovementService"
import {WalletService} from "@/services/wallet/WalletService"

const props = defineProps({
    item: {
        type: Object as PropType<CardModel>,
        required: true
    }
})

const internalAmount = ref(props.item.nextInvoiceValue)
const internalWalletId = ref(0)

async function pay() {
    const confirm = new MfpConfirmAlert('Pagar Próxima Fatura')
    const confirmPay = await confirm.open(`Deseja realmente pagar a próxima fatura do cartão ${props.item.name}?`)
    if (confirmPay) {
        const validationResults = CardsPayFormValidation.validate({walletId: internalWalletId.value})
        if (! validationResults.isValid) {
            return
        }
        await ApiRouter.cards.payNextInvoice(props.item, internalWalletId.value)
        closeModal()
        const toast = new MfpToast()
        await toast.open('Fatura paga com sucesso!')
        CardsService.forceReloadStore()
        MovementService.forceUpdateMovementList()
        WalletService.forceUpdateWalletList()
    }
}

function closeModal() {
    internalAmount.value = 0
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Pagar Fatura" @close-action="closeModal" @save-action="pay" save-action-label="Pagar"/>
    <mfp-modal-content :show-content="true">
        <template #list>
            <mfp-wallet-select label="Carteira" v-model="internalWalletId" v-if="item.nextInvoiceValue"/>
        </template>
        <template #content>
            <ion-row class="center-ion-label-content">
                <ion-col size="2">
                    <ion-icon :icon="alertCircleOutline" size="large" class="ion-margin-end" color="warning"/>
                </ion-col>
                <ion-col size="10">
                    <ion-label>
                        <p v-if="item.nextInvoiceValue">
                            Será pago a próxima fatura no valor
                            <strong>{{ UtilMoney.formatValueToBr(internalAmount) }}</strong> que está em
                            aberto no cartão <strong>{{item.name}}</strong>.
                        </p>
                        <p v-else>
                            Não há fatura em aberto para o cartão <strong>{{item.name}}</strong>.
                        </p>
                    </ion-label>
                </ion-col>
            </ion-row>
        </template>
    </mfp-modal-content>
</template>