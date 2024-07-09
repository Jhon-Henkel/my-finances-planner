<script setup lang="ts">
import {IonItem, IonSelect, IonSelectOption} from "@ionic/vue"
import {onMounted, ref} from "vue"
import {MovementService} from "@/services/movement/MovementService"

const props = defineProps(
    {
        label: {
            type: String,
            required: false,
            default: 'Tipo'
        },
        placeholder: {
            type: String,
            required: false,
            default: 'Selecione'
        },
        forFilter: {
            type: Boolean,
            required: false,
            default: false
        },
        modelValue: Number,
    }
)

const transactionTypeSelectOptions = {
    header: 'Tipo',
    subHeader: 'Selecione o tipo da transação',
}

const movementTypes = ref()

const emit = defineEmits(['update:modelValue'])

function updateValue(value: any) {
    emit('update:modelValue', value)
}

onMounted(() => {
    movementTypes.value = props.forFilter ? MovementService.getTypesListForFilter() : MovementService.getTypesList()
})
</script>

<template>
    <ion-item>
        <ion-select
            :label="label"
            :interface-options="transactionTypeSelectOptions"
            :placeholder="placeholder"
            interface="action-sheet"
            cancel-text="Cancelar"
            @ionChange="updateValue($event.detail.value)"
        >
            <ion-item v-for="(item, index) in movementTypes" :key="index">
                <ion-select-option :value="item.value">
                    {{ item.label }}
                </ion-select-option>
            </ion-item>
        </ion-select>
    </ion-item>
</template>