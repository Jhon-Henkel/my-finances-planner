<script setup lang="ts">
import {IonItem, IonSelect, IonSelectOption} from "@ionic/vue"
import {onMounted} from "vue"
import {useCreditCardStore} from "@/modules/credit-card/store/CreditCardStore"

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
const cardStore = useCreditCardStore()
const cardsSelectOptions = {header: 'Cartões', subHeader: 'Selecione o cartão'}

function updateValue(value: any) {
    emit('update:modelValue', value)
}

onMounted(async () => {
    await cardStore.load()
})
</script>

<template>
    <ion-item>
        <ion-select
            :label="label"
            :interface-options="cardsSelectOptions"
            :placeholder="placeholder"
            fill="solid"
            :value="modelValue"
            interface="action-sheet"
            cancel-text="Cancelar"
            @ionChange="updateValue($event.detail.value)"
        >
            <ion-item v-for="(card, index) in cardStore.activeCards" :key="index">
                <ion-select-option :value="card.id">
                    {{ card.name }}
                </ion-select-option>
            </ion-item>
        </ion-select>
    </ion-item>
</template>
