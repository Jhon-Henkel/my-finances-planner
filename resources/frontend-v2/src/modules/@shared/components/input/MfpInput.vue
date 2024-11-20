<script setup lang="ts">
import {IonIcon, IonInput, IonItem, IonText} from '@ionic/vue'
import {UtilString} from "@/modules/@shared/util/UtilString"

const props = defineProps({
    label: String,
    placeholder: String,
    modelValue: [String, Number],
    clearInput: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    icon: {
        type: String,
        default: ''
    },
    type: {
        type: String,
        default: 'text',
        validator: (value: string) => ['decimal', 'email', 'number', 'tel', 'text', 'password'].includes(value)
    }
})
const emit = defineEmits(['update:modelValue'])

function updateValue(value: any) {
    value = props.type == 'text' ? UtilString.capitalizeFirstLetters(value) : value
    emit('update:modelValue', value)
}
</script>

<template>
    <ion-item>
        <ion-icon slot="start" :icon="icon" v-if="icon.length > 0"/>
        <ion-input
            :type="type"
            :value="modelValue"
            :placeholder="placeholder"
            :clear-input="clearInput"
            label-placement="floating"
            @input="updateValue($event.target.value)"
            :autocorrect="type == 'text' ? 'on' : 'off'"
            :autocomplete="type == 'text' ? 'on' : 'off'"
        >
            <div slot="label">
                {{ label }}
                <ion-text color="danger" v-if="required"> *</ion-text>
            </div>
            <slot/>
        </ion-input>
    </ion-item>
</template>
