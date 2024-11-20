<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {modalController} from "@ionic/vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import {PropType, ref} from "vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import {PanoramaService} from "@/modules/panorama/service/PanoramaService"
import {InvoiceModel} from "@/modules/invoice/model/invoiceModel"
import {IonLabel} from "@ionic/vue"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {PayReceiveModel} from "@/modules/pay-receive/model/PayReceiveModel"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {MovementService} from "@/modules/movement/service/MovementService"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {InvoiceService} from "@/modules/invoice/service/InvoiceService"

const props = defineProps({
    item: {
        type: Object as PropType<InvoiceModel>,
        required: true
    }
})

const internalAmount = ref(InvoiceService.getNextInstallmentValue(props.item))
const internalWalletId = ref(props.item.countId)
const internalPartial = ref(false)

async function pay() {
    const confirm = new MfpConfirmAlert('Pagar Despesa')
    const confirmPay = await confirm.open(`Deseja realmente pagar essa despesa (${props.item.name})?`)
    if (confirmPay) {
        const payModel = new PayReceiveModel(internalAmount.value, internalWalletId.value, internalPartial.value)
        await ApiRouter.futureExpense.pay(props.item.id, payModel)
        closeModal()
        const toast = new MfpToast()
        await toast.open('Despesa paga com sucesso!')
        await WalletService.forceUpdateWalletList()
        await PanoramaService.forceReloadStore()
        await MovementService.forceUpdateMovementList()
    }
}

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Pagar Despesa" @close-action="closeModal" @save-action="pay" save-action-label="Pagar"/>
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
    </mfp-modal-content>
</template>
