<script setup lang="ts">
import {
    IonCard,
    IonCardContent,
    IonContent,
    IonLabel,
    IonList,
    IonSegment,
    IonSegmentButton,
    IonText,
    modalController
} from "@ionic/vue"
import {ref, watch, watchEffect} from "vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import MfpInput from "@/modules/@shared/components/input/MfpInput.vue"
import MfpWalletSelect from "@/modules/@shared/components/select/MfpWalletSelect.vue"
import {MovementService} from "@/modules/movement/service/MovementService"
import {MovementModel} from "@/modules/movement/model/MovementModel"
import {TransferService} from "@/modules/movement/service/TransferService"
import {MovementFormValidation} from "@/modules/movement/validation/MovementFormValidation"
import {TransferFormValidation} from "@/modules/movement/validation/TransferFormValidation"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {useFinancialHealthStore} from "@/modules/financial-health/store/financialHealthStore"
import {useAuthStore} from "@/modules/login/store/AuthStore"
import {SpendingPlanService} from "@/modules/spending-plan/service/SpendingPlanService"
import {useWalletStore} from "@/modules/wallet/store/WalletStore"

const props = defineProps(
    {
        movement: {
            type: MovementModel
        }
    }
)

const internalMovement = ref(MovementService.emptyMovement())
const internalTransfer = ref(TransferService.emptyTransfer())
const title = ref('Nova Movimentação')
const insertType = ref('movement')
const movementType = ref('expense')
const editMode = ref(false)
const walletStore = useWalletStore()
const walletAmount = ref(0)

async function updateWalletAmount() {
    if (editMode.value) {
        return
    }
    await walletStore.getWallets
    walletAmount.value = walletStore.searchWallet(internalMovement.value.walletId)?.amount ?? 0
}

async function saveItem() {
    const toast = new MfpToast()
    if (insertType.value === 'movement') {
        const validationResult = MovementFormValidation.validate(internalMovement.value)
        if (!validationResult.isValid) {
            return
        }
        if (internalMovement.value.id) {
            const moneyValue = UtilMoney.formatValueToBr(internalMovement.value.amount)
            let message = `O valor na conta referente a essa movimentação será atualizado! `
            message += `Nome: ${internalMovement.value.description}, Valor: ${moneyValue}`
            const confirmAlert = new MfpConfirmAlert("Deseja atualizar a movimentação?")
            const confirm = await confirmAlert.open(message)
            if (confirm) {
                await MovementService.update(internalMovement.value)
                await toast.open('Movimentação atualizada com sucesso!')
                closeModal()
                await MovementService.forceUpdateMovementList()
                await WalletService.forceUpdateWalletList()
                await SpendingPlanService.reloadStore()
            }
            return
        }
        await MovementService.create(internalMovement.value)
        await toast.open('Movimentação cadastrada com sucesso!')
        closeModal()
        if (useAuthStore().user?.plan != 'Free') {
            await useFinancialHealthStore().load()
        }
    } else if (insertType.value === 'transfer') {
        const validationResult = TransferFormValidation.validate(internalTransfer.value)
        if (!validationResult.isValid) {
            return
        }
        await TransferService.create(internalTransfer.value)
        await toast.open('Transferência cadastrada com sucesso!')
        closeModal()
    }
    await MovementService.forceUpdateMovementList()
    await SpendingPlanService.reloadStore()
    await WalletService.forceUpdateWalletList()
}

function closeModal() {
    internalMovement.value = MovementService.emptyMovement()
    internalTransfer.value = TransferService.emptyTransfer()
    title.value = 'Nova Movimentação'
    editMode.value = false
    insertType.value = 'movement'
    modalController.dismiss()
    movementType.value = 'expense'
}

function changeInsertType(event: any) {
    insertType.value = event.detail.value
    if (insertType.value === 'movement') {
        title.value = 'Nova Movimentação'
    } else if (insertType.value === 'transfer') {
        title.value = 'Nova Transferência'
    }
}

function changeMovementType(event: any) {
    movementType.value = event.detail.value
    if (movementType.value === 'income') {
        internalMovement.value.type = MovementService.incomeType
    } else if (movementType.value === 'expense') {
        internalMovement.value.type = MovementService.expenseType
    }
}

watchEffect(() => {
    if (props.movement) {
        title.value = 'Editar Movimentação'
        internalMovement.value = props.movement
        editMode.value = true
    }
})

watch(() => internalMovement.value.walletId, () => {
    updateWalletAmount()
})
</script>

<template>
    <mfp-modal-header :title="title" @close-action="closeModal" @save-action="saveItem"/>
    <ion-content class="ion-padding">
        <ion-segment :value="insertType" @ionChange="changeInsertType" v-if="! editMode">
            <ion-segment-button value="movement">
                <ion-label>Movimentação</ion-label>
            </ion-segment-button>
            <ion-segment-button value="transfer">
                <ion-label>Transferência</ion-label>
            </ion-segment-button>
        </ion-segment>
        <div class="ion-padding-top ion-padding-bottom">
            <div v-if="insertType === 'movement'">
                <ion-segment :value="movementType" @ionChange="changeMovementType" v-if="! editMode">
                    <ion-segment-button value="income">
                        <ion-label color="success">Entrada</ion-label>
                    </ion-segment-button>
                    <ion-segment-button value="expense">
                        <ion-label color="danger">Saída</ion-label>
                    </ion-segment-button>
                </ion-segment>
                <div class="ion-text-center">
                    <ion-label v-show="editMode">
                        <ion-text>
                            Carteira: {{ internalMovement.walletName }}
                        </ion-text>
                    </ion-label>
                </div>
                <ion-card class="ion-margin-vertical" v-show="!editMode">
                    <ion-card-content>
                        <ion-label>
                            <p>Saldo conta selecionada: <strong>{{ UtilMoney.formatValueToBr(walletAmount) }}</strong></p>
                        </ion-label>
                    </ion-card-content>
                </ion-card>
                <ion-list :inset="true">
                    <mfp-input
                        v-model="internalMovement.description"
                        label="Descrição"
                        placeholder="Do que é essa movimentação?"
                    />
                    <mfp-input-money v-model="internalMovement.amount"/>
                    <mfp-wallet-select label="Conta" v-model="internalMovement.walletId" v-show="! editMode"/>
                </ion-list>
            </div>
            <div v-else-if="insertType === 'transfer'">
                <ion-list :inset="true">
                    <mfp-input-money v-model="internalTransfer.amount"/>
                    <mfp-wallet-select label="Origem" v-model="internalTransfer.originId"/>
                    <mfp-wallet-select label="Destino" v-model="internalTransfer.destinationId"/>
                </ion-list>
            </div>
        </div>
    </ion-content>
</template>
