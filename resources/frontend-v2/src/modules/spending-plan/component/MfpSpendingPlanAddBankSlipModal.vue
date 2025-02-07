<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {IonCol, IonButton, IonRow, modalController, IonText} from "@ionic/vue"
import {ref} from "vue"
import {SpendingPlanModel} from "@/modules/spending-plan/model/SpendingPlanModel"
import {UtilCalendar} from "../../@shared/util/UtilCalendar";
import {UtilMoney} from "../../@shared/util/UtilMoney";
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert";
import {SpendingPlanService} from "@/modules/spending-plan/service/SpendingPlanService";
import {useSpendingPlanStore} from "@/modules/spending-plan/store/SpendingPlanStore";

const props = defineProps({
    futureExpense: {
        type: Object as () => SpendingPlanModel,
        required: true
    }
})

const bankSlipCode = ref(props.futureExpense.bankSlipCode ?? '');

async function add() {
    const data = props.futureExpense
    const confirm = new MfpConfirmAlert('Revisão')
    const result = await confirm.open(`Adicionar o código de barras no boleto ${data.description}?`)
    if (!result) {
        return
    }
    data.bankSlipCode = bankSlipCode.value
    await SpendingPlanService.update(data, data.installments == 0)
    closeModal()
    const store = useSpendingPlanStore()
    await store.load()
}

async function paste() {
    try {
        bankSlipCode.value = await navigator.clipboard.readText();
    } catch (error) {
        console.error("Erro ao acessar a área de transferência:", error);
    }
}

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Adicionar Boleto" @close-action="closeModal" @save-action="add" save-action-label="Adicionar"/>
    <ion-row class="ion-margin-top">
        <ion-col class="ion-text-center">
            Despesa: {{ futureExpense.description }}
        </ion-col>
    </ion-row>
    <ion-row>
        <ion-col class="ion-text-center">
            Valor Atual: {{ UtilMoney.formatValueToBr(futureExpense.amount) }}
        </ion-col>
    </ion-row>
    <ion-row>
        <ion-col class="ion-text-center">
            Próximo Vencimento: {{ UtilCalendar.formatStringToBr(futureExpense.forecast) }}
        </ion-col>
    </ion-row>
    <mfp-modal-content>
        <template #list>
            <ion-row>
                <ion-col class="ion-text-center">
                    <ion-text>
                        <strong>Código de barras:</strong> {{ bankSlipCode }}
                    </ion-text>
                </ion-col>
            </ion-row>
        </template>
        <template #footer>
            <ion-row>
                <ion-col class="ion-text-center">
                    <ion-button type="button" @click="paste()" class="ion-margin-end">Colar</ion-button>
                    <ion-button type="button" @click="bankSlipCode = ''" color="danger">Limpar</ion-button>
                </ion-col>
            </ion-row>
        </template>
    </mfp-modal-content>
</template>
