<script setup lang="ts">
import {IonItem, IonToggle} from "@ionic/vue"

const props = defineProps({
    label: {
        type: String,
        required: true
    },
    modelValue: Boolean
})

const emit = defineEmits(['update:modelValue'])

function updateValue() {
    emit('update:modelValue', !props.modelValue)
}
</script>

<template>
    <ion-item>
        <ion-toggle :checked="modelValue" @ion-change="updateValue">
            {{ label }}
        </ion-toggle>
    </ion-item>
</template>
