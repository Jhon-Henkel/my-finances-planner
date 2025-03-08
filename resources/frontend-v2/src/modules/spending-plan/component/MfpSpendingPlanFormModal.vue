<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {modalController} from "@ionic/vue"
import {onMounted, ref} from "vue"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import MfpInputDate from "@/modules/@shared/components/input/MfpInputDate.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {SpendingPlanModel} from "@/modules/spending-plan/model/SpendingPlanModel"
import {SpendingPlanService} from "@/modules/spending-plan/service/SpendingPlanService"
import {SpendingPlanFormValidation} from "@/modules/spending-plan/validation/SpendingPlanFormValidation"
import {useSpendingPlanStore} from "@/modules/spending-plan/store/SpendingPlanStore"

const props = defineProps({
    futureExpense: SpendingPlanModel
})

const internalFutureExpense = props.futureExpense ? ref(props.futureExpense) : ref(SpendingPlanService.makeEmptySpendingPlan())
const title = props.futureExpense ? 'Editar Gasto' : 'Cadastrar Gasto'
const fixExpense = ref(false)

async function save() {
    const validationResult = SpendingPlanFormValidation.validate(internalFutureExpense.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalFutureExpense.value.id) {
        await SpendingPlanService.update(internalFutureExpense.value, fixExpense.value)
        toastMessage = 'Gasto atualizado com sucesso!'
        closeModal()
    } else {
        await SpendingPlanService.create(internalFutureExpense.value, fixExpense.value)
        toastMessage = 'Gasto cadastrado com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    const store = useSpendingPlanStore()
    await store.load()
}

function closeModal() {
    internalFutureExpense.value = SpendingPlanService.makeEmptySpendingPlan()
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
                type="number"
                v-if="!fixExpense"
            />
            <mfp-wallet-select label="Carteira Preferencial" v-model="internalFutureExpense.walletId"/>
            <mfp-input-toggle v-model="internalFutureExpense.variableSpending" label="Despesa Variável"/>
            <mfp-input v-model="internalFutureExpense.observations" label="Observações" placeholder="Observações Gerais"/>
        </template>
    </mfp-modal-content>
</template>
