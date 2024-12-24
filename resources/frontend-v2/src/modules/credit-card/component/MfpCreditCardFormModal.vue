<script setup lang="ts">
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {modalController} from "@ionic/vue"
import {ref} from "vue"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {CreditCardModel} from "@/modules/credit-card/model/CreditCardModel"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"
import {CreditCardFormValidation} from "@/modules/credit-card/validation/CreditCardFormValidation"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"

const props = defineProps({
    card: CreditCardModel
})

const title = props.card ? 'Editar Cartão' : 'Cadastrar Cartão'
const internalCard = props.card ? ref(props.card) : ref(CreditCardService.makeEmptyCard())

function save() {
    internalCard.value.closingDay = parseInt(String(internalCard.value.closingDay))
    internalCard.value.dueDate = parseInt(String(internalCard.value.dueDate))
    const validationResult = CreditCardFormValidation.validate(internalCard.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalCard.value.id) {
        CreditCardService.update(internalCard.value)
        toastMessage = 'Cartão atualizado com sucesso!'
        closeModal()
    } else {
        CreditCardService.create(internalCard.value)
        toastMessage = 'Cartão cadastrado com sucesso!'
        closeModal()
    }
    toast.open(toastMessage)
}

function closeModal() {
    internalCard.value = CreditCardService.makeEmptyCard()
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="save"/>
    <mfp-modal-content>
        <template #list>
            <mfp-input v-model="internalCard.name" label="Descrição" placeholder="Nome do Cartão"/>
            <mfp-input-money v-model="internalCard.limit" label="Limite Total"/>
            <mfp-input
                v-model="internalCard.dueDate"
                label="Dia Vencimento"
                placeholder="Dia que a fatura vence"
                type="number"
            />
            <mfp-input
                v-model="internalCard.closingDay"
                label="Dia Fechamento"
                placeholder="Dia que a fatura fecha"
                type="number"
            />
            <mfp-input-toggle v-model="internalCard.active" label="Ativar cartão"/>
        </template>
    </mfp-modal-content>
</template>
