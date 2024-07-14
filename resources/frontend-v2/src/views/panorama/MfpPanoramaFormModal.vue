<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {modalController} from "@ionic/vue"
import {onMounted, ref} from "vue"
import {FutureExpenseService} from "@/services/future-expense/FutureExpenseService"
import MfpInput from "@/components/input/MfpInput.vue"
import MfpInputMoney from "@/components/input/MfpInputMoney.vue"
import MfpInputToggle from "@/components/input/MfpInputToggle.vue"
import MfpWalletSelect from "@/components/select/MfpWalletSelect.vue"
import MfpInputDate from "@/components/input/MfpInputDate.vue"
import {FutureExpenseFormValidation} from "@/form-validation/future-expense/FutureExpenseFormValidation"
import {MfpToast} from "@/components/toast/MfpToast"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {FutureExpenseModel} from "@/model/future-expense/FutureExpenseModel"

const props = defineProps({
    futureExpense: FutureExpenseModel
})

const internalFutureExpense = props.futureExpense ? ref(props.futureExpense) : ref(FutureExpenseService.makeEmptyFutureExpense())
const title = props.futureExpense ? 'Editar Gasto' : 'Cadastrar Gasto'
const fixExpense = ref(false)

async function save() {
    const isValid = FutureExpenseFormValidation.validate(internalFutureExpense.value)
    if (!isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalFutureExpense.value.id) {
        await FutureExpenseService.update(internalFutureExpense.value, fixExpense.value)
        toastMessage = 'Gasto atualizado com sucesso!'
        closeModal()
    } else {
        await FutureExpenseService.create(internalFutureExpense.value, fixExpense.value)
        toastMessage = 'Gasto cadastrado com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    await PanoramaService.forceReloadStore()
}

function closeModal() {
    internalFutureExpense.value = FutureExpenseService.makeEmptyFutureExpense()
    modalController.dismiss()
}

onMounted(() => {
    if (props.futureExpense) {
        fixExpense.value = props.futureExpense.installments === 0
    }
})
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="save"/>
    <mfp-modal-content>
        <template #list>
            <mfp-input v-model="internalFutureExpense.description" label="Descrição" placeholder="Nome da Despesa"/>
            <mfp-input-date v-model="internalFutureExpense.forecast" label="Próximo Pagamento"/>
            <mfp-input-money v-model="internalFutureExpense.amount" label="Valor da Parcela"/>
            <mfp-input-toggle v-model="fixExpense" label="Despesa Fixa"/>
            <mfp-input
                v-model="internalFutureExpense.installments"
                label="Parcelas Restantes"
                placeholder="Quantas parcelas faltam?"
                type="numeric"
                v-if="!fixExpense"
            />
            <mfp-wallet-select label="Carteira Preferencial" v-model="internalFutureExpense.walletId"/>
        </template>
    </mfp-modal-content>
</template>