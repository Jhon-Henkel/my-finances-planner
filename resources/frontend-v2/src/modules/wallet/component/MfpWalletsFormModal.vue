<script setup lang="ts">
import {modalController,} from "@ionic/vue"
import {ref} from "vue"
import {WalletModel} from "@/modules/wallet/model/WalletModel"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {WalletFormValidation} from "@/modules/wallet/validation/WalletFormValidation"
import {MovementService} from "@/modules/movement/service/MovementService"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"

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
            <mfp-input-money v-model="internalWallet.amount" label="Saldo Atual"/>
            <mfp-input-toggle v-model="internalWallet.hideValue" label="Ocultar saldo"/>
            <mfp-input-toggle v-model="internalWallet.active" label="Ativar carteira"/>
        </template>
    </mfp-modal-content>
</template>
