<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {IonCard, IonCardContent, IonCol, IonIcon, IonLabel, IonRow, IonText, modalController} from "@ionic/vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import {PropType, ref, watch} from "vue"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {alertCircleOutline} from "ionicons/icons"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {MovementService} from "@/modules/movement/service/MovementService"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {CreditCardModel} from "@/modules/credit-card/model/CreditCardModel"
import {CreditCardPayFormValidation} from "@/modules/credit-card/validation/CreditCardPayFormValidation"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"
import {CreditCardInvoiceItemService} from "@/modules/credit-card/service/CreditCardInvoiceItemService"
import {useWalletStore} from "@/modules/wallet/store/WalletStore"

const props = defineProps({
    item: {
        type: Object as PropType<CreditCardModel>,
        required: true
    }
})

const internalAmount = ref(props.item.nextInvoiceValue)
const internalWalletId = ref(0)
const walletStore = useWalletStore()
const walletAmount = ref(0)
const walletAmountColor = ref('medium')

async function updateWalletAmount() {
    await walletStore.getWallets
    walletAmount.value = walletStore.searchWallet(internalWalletId.value)?.amount ?? 0
    if (walletAmount.value - internalAmount.value < 0) {
        walletAmountColor.value = 'danger'
    } else {
        walletAmountColor.value = 'success'
    }
}

async function pay() {
    const validationResults = CreditCardPayFormValidation.validate({walletId: internalWalletId.value})
    if (! validationResults.isValid) {
        return
    }
    const confirm = new MfpConfirmAlert('Pagar Próxima Fatura')
    const confirmPay = await confirm.open(`Deseja realmente pagar a próxima fatura do cartão ${props.item.name}?`)
    if (confirmPay) {
        await ApiRouter.cards.payNextInvoice(props.item, internalWalletId.value)
        closeModal()
        const toast = new MfpToast()
        await toast.open('Fatura paga com sucesso!')
        await CreditCardService.reloadStore()
        await CreditCardInvoiceItemService.reloadStore(null)
        await MovementService.forceUpdateMovementList()
        await WalletService.forceUpdateWalletList()
    }
}

function closeModal() {
    internalAmount.value = 0
    modalController.dismiss()
}

watch(() => internalWalletId.value, () => {
    updateWalletAmount()
})
</script>

<template>
    <mfp-modal-header title="Pagar Fatura" @close-action="closeModal" @save-action="pay" save-action-label="Pagar"/>
    <ion-card class="ion-margin-vertical">
        <ion-card-content>
            <ion-label>
                <p>Pagar Fatura: <strong>{{ item.name }}</strong></p>
                <p>Saldo conta selecionada: <ion-text :color="walletAmountColor"><strong>{{ UtilMoney.formatValueToBr(walletAmount) }}</strong></ion-text></p>
                <br>
                <p>
                    Ao pagar a fatura, será pago a <strong>primeira</strong> fatura, independente de qual
                    fatura esteja selecionada.
                </p>
            </ion-label>
        </ion-card-content>
    </ion-card>
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
