<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {modalController} from "@ionic/vue"
import {onMounted, ref} from "vue"
import MfpInput from "@/components/input/MfpInput.vue"
import MfpInputMoney from "@/components/input/MfpInputMoney.vue"
import MfpInputToggle from "@/components/input/MfpInputToggle.vue"
import MfpWalletSelect from "@/components/select/MfpWalletSelect.vue"
import MfpInputDate from "@/components/input/MfpInputDate.vue"
import {MfpToast} from "@/components/toast/MfpToast"
import {FutureProfitsModel} from "@/model/future-profits/FutureProfitsModel"
import {FutureProfitsService} from "@/services/future-profits/FutureProfitsService"
import {FutureProfitFormValidation} from "@/form-validation/future-profit/FutureProfitFormValidation"

const props = defineProps({
    futureProfit: FutureProfitsModel,
})

const internalFutureProfit = props.futureProfit ? ref(props.futureProfit) : ref(FutureProfitsService.makeEmptyFutureProfit())
const title = props.futureProfit ? 'Editar Receita' : 'Cadastrar Receita'
const fixProfit = ref(false)

async function save() {
    const isValid = FutureProfitFormValidation.validate(internalFutureProfit.value)
    if (!isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalFutureProfit.value.id) {
        await FutureProfitsService.update(internalFutureProfit.value, fixProfit.value)
        toastMessage = 'Receita atualizado com sucesso!'
        closeModal()
    } else {
        await FutureProfitsService.create(internalFutureProfit.value, fixProfit.value)
        toastMessage = 'Receita cadastrado com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    await FutureProfitsService.forceLoadStore()
}

function closeModal() {
    internalFutureProfit.value = FutureProfitsService.makeEmptyFutureProfit()
    modalController.dismiss()
}

onMounted(() => {
    if (props.futureProfit) {
        fixProfit.value = props.futureProfit.installments === 0
    }
})
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="save"/>
    <mfp-modal-content>
        <template #list>
            <mfp-input v-model="internalFutureProfit.description" label="Descrição" placeholder="Nome da Despesa"/>
            <mfp-input-date v-model="internalFutureProfit.forecast" label="Próximo Recebimento"/>
            <mfp-input-money v-model="internalFutureProfit.amount" label="Valor da Parcela"/>
            <mfp-input-toggle v-model="fixProfit" label="Recebimento Fixo"/>
            <mfp-input
                v-model="internalFutureProfit.installments"
                label="Parcelas Restantes"
                placeholder="Quantas parcelas faltam?"
                type="numeric"
                v-if="!fixProfit"
            />
            <mfp-wallet-select label="Carteira Preferencial" v-model="internalFutureProfit.walletId"/>
        </template>
    </mfp-modal-content>
</template>