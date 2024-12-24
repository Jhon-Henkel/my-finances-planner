<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {IonCard, IonCardContent, IonLabel, modalController} from "@ionic/vue"
import {onMounted, ref, watch} from "vue"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import MfpInputDate from "@/modules/@shared/components/input/MfpInputDate.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import MfpCreditCardSelect from "@/modules/@shared/components/select/MfpCreditCardSelect.vue"
import {useRoute} from "vue-router"
import {SpendingPlanService} from "@/modules/spending-plan/service/SpendingPlanService"
import {CreditCardInvoiceItemModel} from "@/modules/credit-card/model/CreditCardInvoiceItemModel"
import {CreditCardInvoiceItemService} from "@/modules/credit-card/service/CreditCardInvoiceItemService"
import {CreditCardInvoiceItemFormValidation} from "@/modules/credit-card/validation/CreditCardInvoiceItemFormValidation"
import {CreditCardService} from "@/modules/credit-card/service/CreditCardService"
import {useCreditCardStore} from "@/modules/credit-card/store/CreditCardStore"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"

const props = defineProps({
    invoiceItem: {
        type: Object as () => CreditCardInvoiceItemModel,
        default: null,
    },
    cardIdProp: Number,
})

const cardId = props.cardIdProp ?? parseInt(String(useRoute().params.id))
const internalInvoiceItem = props.invoiceItem ? ref(props.invoiceItem) : ref(CreditCardInvoiceItemService.makeEmptyInvoiceItem())
internalInvoiceItem.value.creditCardId = cardId
const title = props.invoiceItem ? 'Editar Parcela' : 'Cadastrar Parcela'
const fixExpense = ref(false)
const cardStore = useCreditCardStore()
const cardLimit = ref(0)

if (internalInvoiceItem.value.creditCardId > 0) {
    updateCardLimit()
}

async function updateCardLimit() {
    if (! cardStore.isLoaded) {
        await cardStore.load()
    }
    cardLimit.value = cardStore.searchCard(internalInvoiceItem.value.creditCardId)?.limit ?? 0
}
async function save() {
    const validationResult = CreditCardInvoiceItemFormValidation.validate(internalInvoiceItem.value)
    if (!validationResult.isValid) {
        return
    }
    const toast = new MfpToast()
    let toastMessage = ''
    if (internalInvoiceItem.value.id) {
        await CreditCardInvoiceItemService.update(internalInvoiceItem.value, fixExpense.value)
        toastMessage = 'Parcela atualizada com sucesso!'
        closeModal()
    } else {
        await CreditCardInvoiceItemService.create(internalInvoiceItem.value, fixExpense.value)
        toastMessage = 'Parcela cadastrada com sucesso!'
        closeModal()
    }
    await toast.open(toastMessage)
    await CreditCardInvoiceItemService.reloadStore(props.cardIdProp ?? null)
    await CreditCardService.reloadStore()
    await SpendingPlanService.reloadStore()
}

function closeModal() {
    internalInvoiceItem.value = CreditCardInvoiceItemService.makeEmptyInvoiceItem()
    modalController.dismiss()
}

onMounted(() => {
    if (props.invoiceItem) {
        fixExpense.value = props.invoiceItem.installments === 0
    }
})

watch(() => internalInvoiceItem.value.creditCardId, () => {
    updateCardLimit()
})
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="save"/>
    <ion-card class="ion-margin-vertical">
        <ion-card-content>
            <ion-label>
                <p>Limite restante cartão selecionado: <strong>{{ UtilMoney.formatValueToBr(cardLimit) }}</strong></p>
            </ion-label>
        </ion-card-content>
    </ion-card>
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
