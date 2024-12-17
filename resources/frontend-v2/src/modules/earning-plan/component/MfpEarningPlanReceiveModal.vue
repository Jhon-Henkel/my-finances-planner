<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {IonLabel, modalController} from "@ionic/vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import {PropType, ref} from "vue"
import MfpInputToggle from "@/modules/@shared/components/input/MfpInputToggle.vue"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {PayReceiveModel} from "@/modules/pay-receive/model/PayReceiveModel"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {MovementService} from "@/modules/movement/service/MovementService"
import EarningPlanApiGetDto from "@/modules/earning-plan/dto/earning-plan.api.get.dto"
import {EarningPlanService} from "@/modules/earning-plan/service/EarningPlanService"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"

const props = defineProps({
    item: {
        type: Object as PropType<EarningPlanApiGetDto>,
        required: true
    }
})

const internalAmount = ref(props.item.amount)
const internalWalletId = ref(props.item.wallet_id)
const internalPartial = ref(false)

async function receive() {
    const confirm = new MfpConfirmAlert('Receber Receita')
    const confirmReceive = await confirm.open(`Deseja realmente receber a receita (${props.item.description})?`)
    if (confirmReceive) {
        const receiveModel = new PayReceiveModel(internalAmount.value, internalWalletId.value, internalPartial.value)
        await ApiRouter.futureProfits.receive(props.item.id, receiveModel)
        closeModal()
        const toast = new MfpToast()
        await toast.open('Receita recebida com sucesso!')
        await WalletService.forceUpdateWalletList()
        await EarningPlanService.reloadStore()
        await MovementService.forceUpdateMovementList()
    }
}

function closeModal() {
    modalController.dismiss()
}
</script>

<template>
    <mfp-modal-header title="Receber Receita" @close-action="closeModal" @save-action="receive" save-action-label="Receber"/>
    <ion-card class="ion-margin">
        <ion-card-content>
            <ion-label>
                <p>
                    Ao receber a receita, será recebido a <strong>primeira</strong> parcela, independente de qual
                    parcela esteja selecionada.
                </p>
            </ion-label>
        </ion-card-content>
    </ion-card>
    <mfp-modal-content :show-content="internalPartial">
        <template #list>
            <mfp-input-money label="Valor" v-model="internalAmount"/>
            <mfp-wallet-select label="Carteira" v-model="internalWalletId"/>
            <mfp-input-toggle label="Receber Parcialmente" v-model="internalPartial"/>
        </template>
        <template #content>
            <ion-label>
                <p>
                    Ao receber parcialmente, será gerado um novo plano de receita com o valor restante.
                </p>
            </ion-label>
        </template>
    </mfp-modal-content>
</template>
