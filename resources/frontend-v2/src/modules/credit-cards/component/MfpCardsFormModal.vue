<script setup lang="ts">
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {CardModel} from "@/modules/credit-cards/model/CardModel"
import {modalController} from "@ionic/vue"
import {ref} from "vue"
import {CardsService} from "@/modules/credit-cards/service/CardsService"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import {CardsFormValidation} from "@/modules/credit-cards/validation/CardsFormValidation"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"

const props = defineProps({
    card: CardModel
})

const title = props.card ? 'Editar Cartão' : 'Cadastrar Cartão'
const internalCard = props.card ? ref(props.card) : ref(CardsService.makeEmptyCard())

function save() {
    internalCard.value.closingDay = parseInt(String(internalCard.value.closingDay))
    internalCard.value.dueDate = parseInt(String(internalCard.value.dueDate))
    const validationResult = CardsFormValidation.validate(internalCard.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalCard.value.id) {
        CardsService.update(internalCard.value)
        toastMessage = 'Cartão atualizado com sucesso!'
        closeModal()
    } else {
        CardsService.create(internalCard.value)
        toastMessage = 'Cartão cadastrado com sucesso!'
        closeModal()
    }
    toast.open(toastMessage)
}

function closeModal() {
    internalCard.value = CardsService.makeEmptyCard()
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
        </template>
    </mfp-modal-content>
</template>
