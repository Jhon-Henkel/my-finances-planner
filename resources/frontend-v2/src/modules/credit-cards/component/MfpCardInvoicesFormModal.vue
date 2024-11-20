<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {modalController} from "@ionic/vue"
import {onMounted, ref} from "vue"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import MfpInputDate from "@/modules/@shared/components/input/MfpInputDate.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {CardInvoiceItemModel} from "@/modules/credit-cards/model/CardInvoiceItemModel"
import {CardInvoiceItemService} from "@/modules/credit-cards/service/CardInvoiceItemService"
import {CardsInvoiceItemFormValidation} from "@/modules/credit-cards/validation/CardsInvoiceItemFormValidation"
import MfpCreditCardSelect from "@/modules/@shared/components/select/MfpCreditCardSelect.vue"
import {useRoute} from "vue-router"
import {CardsService} from "@/modules/credit-cards/service/CardsService"

const props = defineProps({
    invoiceItem: CardInvoiceItemModel,
    cardIdProp: Number
})

const cardId = props.cardIdProp ?? parseInt(String(useRoute().params.id))
const internalInvoiceItem = props.invoiceItem ? ref(props.invoiceItem) : ref(CardInvoiceItemService.makeEmptyInvoiceItem())
internalInvoiceItem.value.creditCardId = cardId
const title = props.invoiceItem ? 'Editar Parcela' : 'Cadastrar Parcela'
const fixExpense = ref(false)

async function save() {
    const validationResult = CardsInvoiceItemFormValidation.validate(internalInvoiceItem.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalInvoiceItem.value.id) {
        await CardInvoiceItemService.update(internalInvoiceItem.value, fixExpense.value)
        toastMessage = 'Parcela atualizada com sucesso!'
        closeModal()
    } else {
        await CardInvoiceItemService.create(internalInvoiceItem.value, fixExpense.value)
        toastMessage = 'Parcela cadastrada com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    await CardInvoiceItemService.forceReloadStore(props.cardIdProp ?? parseInt(String(useRoute().params.id)))
    await CardsService.forceReloadStore()
    await PanoramaService.forceReloadStore()
}

function closeModal() {
    internalInvoiceItem.value = CardInvoiceItemService.makeEmptyInvoiceItem()
    modalController.dismiss()
}

onMounted(() => {
    if (props.invoiceItem) {
        fixExpense.value = props.invoiceItem.installments === 0
    }
})
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="save"/>
    <mfp-modal-content>
        <template #list>
            <mfp-input v-model="internalInvoiceItem.name" label="Descrição" placeholder="Nome da Despesa"/>
            <mfp-input-date v-model="internalInvoiceItem.nextInstallment" label="Data Registro"/>
            <mfp-input-money v-model="internalInvoiceItem.value" label="Valor da Parcela"/>
            <mfp-input-toggle v-model="fixExpense" label="Parcela Fixa"/>
            <mfp-input
                v-model="internalInvoiceItem.installments"
                label="Parcelas Restantes"
                placeholder="Quantas parcelas faltam?"
                type="number"
                v-if="!fixExpense"
            />
            <mfp-credit-card-select label="Cartão" v-model="internalInvoiceItem.creditCardId"/>
        </template>
    </mfp-modal-content>
</template>
