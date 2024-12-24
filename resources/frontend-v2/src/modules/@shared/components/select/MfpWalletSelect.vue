<script setup lang="ts">
import {IonItem, IonSelect, IonSelectOption} from "@ionic/vue"
import {onMounted} from "vue"
import {useWalletStore} from "@/modules/wallet/store/WalletStore"

defineProps(
    {
        label: {
            type: String,
            required: true
        },
        placeholder: {
            type: String,
            required: false,
            default: 'Selecione'
        },
        modelValue: Number,
    }
)

const emit = defineEmits(['update:modelValue'])
const walletStore = useWalletStore()
const walletsSelectOptions = {header: 'Carteira', subHeader: 'Selecione a carteira'}

function updateValue(value: any) {
    emit('update:modelValue', value)
}

onMounted(async () => {
    await walletStore.getWallets
})
</script>

<template>
    <ion-item>
        <ion-select
            :label="label"
            :interface-options="walletsSelectOptions"
            :placeholder="placeholder"
            fill="solid"
            :value="modelValue"
            interface="action-sheet"
            cancel-text="Cancelar"
            @ionChange="updateValue($event.target.value)"
        >
            <ion-item v-for="(wallet, index) in walletStore.activeWallets" :key="index">
                <ion-select-option :value="wallet.id">
                    {{ wallet.name }}
                </ion-select-option>
            </ion-item>
        </ion-select>
    </ion-item>
</template>
