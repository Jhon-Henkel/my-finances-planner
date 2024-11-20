<script setup lang="ts">
import {IonInput, IonItem} from "@ionic/vue"
import { unformat } from "@/infra/directives/mask/money/util"

const emit = defineEmits(['update:modelValue'])
const inputOptions = {prefix: '', suffix: '', thousands: '.', decimal: ',', precision: 2}

defineProps(
    {
        label: {
            type: String,
            default: 'Valor (R$)',
            required: false
        },
        modelValue: {
            required: true,
            type: [Number, String],
            default: 0
        },
    }
)

function updateValue(event: any) {
    emit('update:modelValue', unformat(event.detail.value, inputOptions.precision))
}
</script>

<template>
    <ion-item>
        <ion-input
            :value="modelValue"
            type="tel"
            :label="label"
            label-placement="floating"
            @ion-change="updateValue($event)"
            v-money="inputOptions"
        />
    </ion-item>
</template>
