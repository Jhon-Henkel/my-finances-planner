<script setup lang="ts">
import {modalController,} from "@ionic/vue"
import {ref} from "vue"
import {WalletModel} from "@/model/wallet/WalletModel"
import {UtilMoney} from "@/util/UtilMoney"
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import MfpInput from "@/components/input/MfpInput.vue"
import MfpInputMoney from "@/components/input/MfpInputMoney.vue"
import {MfpToast} from "@/components/toast/MfpToast"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {WalletService} from "@/services/wallet/WalletService"
import {WalletFormValidation} from "@/form-validation/wallet/WalletFormValidation"
import {MovementService} from "@/services/movement/MovementService"

const props = defineProps({
    wallet: WalletModel
})

const internalWallet = props.wallet ? ref(props.wallet) : ref(WalletService.emptyWallet())
const title = props.wallet ? 'Editar Carteira' : 'Cadastrar Carteira'

async function saveWallet() {
    const validationResult = WalletFormValidation.validate(internalWallet.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalWallet.value.id) {
        const moneyValue = UtilMoney.formatValueToBr(internalWallet.value.amount)
        const confirmTitle = 'Deseja atualizar a carteira? Em caso de atualização de valor, será criado uma movimentação.'
        const confirmAlert = new MfpConfirmAlert(confirmTitle)
        const confirm = await confirmAlert.open(`Nome: ${internalWallet.value.name}, Valor: ${moneyValue}`)
        if (confirm) {
            await WalletService.update(internalWallet.value)
            toastMessage = 'Carteira atualizada com sucesso!'
        }
        closeModal()
        await MovementService.forceUpdateMovementList()
    } else {
        await WalletService.create(internalWallet.value)
        toastMessage = 'Carteira cadastrada com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    await WalletService.forceUpdateWalletList()
}

function closeModal() {
    internalWallet.value = WalletService.emptyWallet()
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="saveWallet"/>
    <mfp-modal-content>
        <template #list>
            <mfp-input v-model="internalWallet.name" label="Descrição" placeholder="Nome da carteira"/>
            <mfp-input-money v-model="internalWallet.amount"/>
        </template>
    </mfp-modal-content>
</template>