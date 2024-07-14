<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {modalController} from "@ionic/vue"
import MfpInputMoney from "@/components/input/MfpInputMoney.vue"
import MfpWalletSelect from "@/components/select/MfpWalletSelect.vue"
import {PropType, ref} from "vue"
import MfpInputToggle from "@/components/input/MfpInputToggle.vue"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {InvoiceModel} from "@/model/invoice/invoiceModel"
import {IonLabel} from "@ionic/vue"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/api/ApiRouter"
import {FutureExpensePayModel} from "@/model/future-expense/FutureExpensePayModel"
import {WalletService} from "@/services/wallet/WalletService"
import {MovementService} from "@/services/movement/MovementService"
import {MfpToast} from "@/components/toast/MfpToast"

const props = defineProps({
    item: {
        type: Object as PropType<InvoiceModel>,
        required: true
    }
})

const internalAmount = ref(PanoramaService.getNextInstallmentValue(props.item))
const internalWalletId = ref(props.item.countId)
const internalPartial = ref(false)

async function pay() {
    const confirm = new MfpConfirmAlert('Pagar Despesa')
    const confirmPay = await confirm.open(`Deseja realmente pagar essa despesa (${props.item.name})?`)
    if (confirmPay) {
        const payModel = new FutureExpensePayModel(internalAmount.value, internalWalletId.value, internalPartial.value)
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
            <mfp-input-toggle label="Pagar parcialmente" v-model="internalPartial"/>
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