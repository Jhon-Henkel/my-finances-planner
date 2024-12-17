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
import {PanoramaService} from "@/modules/panorama/service/PanoramaService"
import {EarningPlanFormValidation} from "@/modules/earning-plan/validation/EarningPlanFormValidation"
import {EarningPlanService} from "@/modules/earning-plan/service/EarningPlanService"
import {useEarningPlanStore} from "@/modules/earning-plan/store/EarningPlanStore"
import {EarningPlanModel} from "@/modules/earning-plan/model/EarningPlanModel"

const props = defineProps({
    futureProfit: EarningPlanModel,
})

const internalFutureProfit = props.futureProfit ? ref(props.futureProfit) : ref(EarningPlanService.makeEmptyFutureProfit())
const title = props.futureProfit ? 'Editar Receita' : 'Cadastrar Receita'
const fixProfit = ref(false)

async function save() {
    const validationResult = EarningPlanFormValidation.validate(internalFutureProfit.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalFutureProfit.value.id) {
        await EarningPlanService.update(internalFutureProfit.value, fixProfit.value)
        toastMessage = 'Receita atualizado com sucesso!'
        closeModal()
    } else {
        await EarningPlanService.create(internalFutureProfit.value, fixProfit.value)
        toastMessage = 'Receita cadastrado com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    const store = useEarningPlanStore()
    await store.load()
    await PanoramaService.forceReloadStore()
}

function closeModal() {
    internalFutureProfit.value = EarningPlanService.makeEmptyFutureProfit()
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
                type="number"
                v-if="!fixProfit"
            />
            <mfp-wallet-select label="Carteira Preferencial" v-model="internalFutureProfit.walletId"/>
        </template>
    </mfp-modal-content>
</template>
