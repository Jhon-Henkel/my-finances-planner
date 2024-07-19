<script setup lang="ts">
import MfpModalHeader from "@/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/components/modal/MfpModalContent.vue"
import {IonCol, IonIcon, IonLabel, IonRow, modalController} from "@ionic/vue"
import MfpInputMoney from "@/components/input/MfpInputMoney.vue"
import {ref} from "vue"
import {FutureExpenseModel} from "@/model/future-expense/FutureExpenseModel"
import {UtilMoney} from "@/util/UtilMoney"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {FutureExpenseService} from "@/services/future-expense/FutureExpenseService"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"
import {informationCircleOutline} from "ionicons/icons"

const props = defineProps({
    futureExpense: {
        type: FutureExpenseModel,
        required: true
    }
})

const internalAmount = ref(0)

async function add() {
    const newExpense = props.futureExpense
    const confirm = new MfpConfirmAlert('Revisão')
    const value = UtilMoney.formatValueToBr(newExpense.amount + internalAmount.value)
    let message = `O novo valor de ${value} será o novo valor dessa despesa planejada `
    if (newExpense.installments == 0) {
        message += 'em todos os meses. Continuar?'
    } else {
        message += `para as ${newExpense.installments} restantes. Continuar?`
    }
    const result = await confirm.open(message)
    if (!result) {
        return
    }
    newExpense.amount += internalAmount.value
    await FutureExpenseService.update(newExpense, newExpense.installments == 0)
    closeModal()
    await PanoramaService.forceReloadStore()
}

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header
        title="Adicionar Valor"
        @close-action="closeModal"
        @save-action="add"
        save-action-label="Adicionar"
    />
    <ion-row class="ion-margin-top">
        <ion-col class="ion-text-center">
            Despesa: {{ futureExpense.description }}
        </ion-col>
    </ion-row>
    <ion-row class="ion-margin-top">
        <ion-col class="ion-text-center">
            Valor Atual:
            <mfp-counter-money :end="futureExpense.amount"/>
        </ion-col>
    </ion-row>
    <mfp-modal-content :show-content="true">
        <template #list>
            <mfp-input-money label="Acrescentar" v-model="internalAmount"/>
        </template>
        <template #content>
            <ion-icon :icon="informationCircleOutline" slot="start"/>
            <ion-label>
                <p>
                    O valor será o novo valor dessa despesa planejada em todos os meses.
                </p>
            </ion-label>
        </template>
    </mfp-modal-content>
</template>