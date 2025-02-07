<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {IonLabel, modalController, IonCard, IonCardContent, IonButton, IonText, IonCol, IonRow} from "@ionic/vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import {PropType, ref, watch} from "vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {PayReceiveModel} from "@/modules/pay-receive/model/PayReceiveModel"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {MovementService} from "@/modules/movement/service/MovementService"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import SpendingPlanApiGetDto from "@/modules/spending-plan/dto/spending-plan.api.get.dto"
import {useWalletStore} from "@/modules/wallet/store/WalletStore"
import {UtilMoney} from "../../@shared/util/UtilMoney"

const props = defineProps({
    item: {
        type: Object as PropType<SpendingPlanApiGetDto>,
        required: true
    },
    store: {
        type: Object,
        required: true
    }
})

const internalAmount = ref(props.item.amount)
const internalWalletId = ref(props.item.wallet_id)
const internalPartial = ref(false)
const walletStore = useWalletStore()
const walletAmount = ref(0)
const walletAmountColor = ref('medium')
const bankSlipCode = ref(props.item.bank_slip_code ?? '');

if (internalWalletId.value > 0) {
    updateWalletAmount()
}

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
    const confirm = new MfpConfirmAlert('Pagar Despesa')
    const confirmPay = await confirm.open(`Deseja realmente pagar essa despesa (${props.item.description})?`)
    if (confirmPay) {
        const payModel = new PayReceiveModel(internalAmount.value, internalWalletId.value, internalPartial.value)
        await ApiRouter.futureExpense.pay(props.item.id, payModel)
        closeModal()
        const toast = new MfpToast()
        await toast.open('Despesa paga com sucesso!')
        await WalletService.forceUpdateWalletList()
        await props.store.load()
        await MovementService.forceUpdateMovementList()
    }
}

function closeModal() {
    modalController.dismiss()
}

async function copyToClipboard() {
    try {
        await navigator.clipboard.writeText(bankSlipCode.value);
    } catch (error) {
        console.error("Erro ao copiar o código de barras:", error);
    }
}

watch(() => internalWalletId.value, () => {
    updateWalletAmount()
})
</script>

<template>
    <mfp-modal-header title="Pagar Despesa" @close-action="closeModal" @save-action="pay" save-action-label="Pagar"/>
    <ion-card class="ion-margin-vertical">
        <ion-card-content>
            <ion-label>
                <p>Pagar: <strong>{{ item.description }}{{item.bank_slip_code}}</strong></p>
                <p>Saldo conta selecionada: <ion-text :color="walletAmountColor"><strong>{{ UtilMoney.formatValueToBr(walletAmount) }}</strong></ion-text></p>
                <br>
                <p>
                    Ao pagar a despesa, será pago a <strong>primeira parcela</strong>, independente de qual
                    parcela esteja selecionada. Caso tenha código de barras, será <strong>excluído</strong>.
                </p>
            </ion-label>
        </ion-card-content>
    </ion-card>
    <mfp-modal-content :show-content="internalPartial">
        <template #list>
            <mfp-input-money label="Valor" v-model="internalAmount"/>
            <mfp-wallet-select label="Carteira" v-model="internalWalletId"/>
            <mfp-input-toggle label="Pagar Parcialmente" v-model="internalPartial"/>
        </template>
        <template #content>
            <ion-label>
                <p>
                    Ao pagar parcialmente, será gerado um novo plano de despesa com o valor restante.
                </p>
            </ion-label>
        </template>
        <template #footer>
            <ion-card class="" v-if="item.bank_slip_code">
                <ion-card-content class="ion-no-margin ion-no-padding">
                    <ion-row class="ion-justify-content-between ion-no-margin ion-no-padding">
                        <ion-col class="ion-text-center ion-align-self-center" size="10">
                            <ion-text>{{ item.bank_slip_code }}</ion-text>
                        </ion-col>
                        <ion-col class="ion-text-right ion-no-margin ion-no-padding">
                            <ion-button @click="copyToClipboard">Copiar</ion-button>
                        </ion-col>
                    </ion-row>
                </ion-card-content>
            </ion-card>
        </template>
    </mfp-modal-content>
</template>
