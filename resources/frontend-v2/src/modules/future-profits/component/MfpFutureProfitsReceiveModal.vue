<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {IonLabel, modalController} from "@ionic/vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import {PropType, ref} from "vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import {InvoiceModel} from "@/modules/invoice/model/invoiceModel"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {PayReceiveModel} from "@/modules/pay-receive/model/PayReceiveModel"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {MovementService} from "@/modules/movement/service/MovementService"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {InvoiceService} from "@/modules/invoice/service/InvoiceService"
import {FutureProfitsService} from "@/modules/future-profits/service/FutureProfitsService"

const props = defineProps({
    item: {
        type: Object as PropType<InvoiceModel>,
        required: true
    }
})

const internalAmount = ref(InvoiceService.getNextInstallmentValue(props.item))
const internalWalletId = ref(props.item.countId)
const internalPartial = ref(false)

async function receive() {
    const confirm = new MfpConfirmAlert('Receber Receita')
    const confirmReceive = await confirm.open(`Deseja realmente receber essa receita (${props.item.name})?`)
    if (confirmReceive) {
        const receiveModel = new PayReceiveModel(internalAmount.value, internalWalletId.value, internalPartial.value)
        await ApiRouter.futureProfits.receive(props.item.id, receiveModel)
        closeModal()
        const toast = new MfpToast()
        await toast.open('Receita recebida com sucesso!')
        await WalletService.forceUpdateWalletList()
        await FutureProfitsService.forceLoadStore()
        await MovementService.forceUpdateMovementList()
    }
}

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Receber Receita" @close-action="closeModal" @save-action="receive" save-action-label="Receber"/>
    <mfp-modal-content :show-content="internalPartial">
        <template #list>
            <mfp-input-money label="Valor" v-model="internalAmount"/>
            <mfp-wallet-select label="Carteira" v-model="internalWalletId"/>
            <mfp-input-toggle label="Receber Parcialmente" v-model="internalPartial"/>
        </template>
        <template #content>
            <ion-label>
                <p>
                    Ao receber parcialmente, será gerado um novo plano de receita com o valor restante.
                </p>
            </ion-label>
        </template>
    </mfp-modal-content>
</template>
