<script setup lang="ts">
import {IonItem, IonDatetime, IonModal, IonDatetimeButton, IonText} from '@ionic/vue'
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"

defineProps({
    label: {
        type: String,
        required: true
    },
    modelValue: String,
})

const emit = defineEmits(['update:modelValue'])

function updateValue(value: any) {
    if (value === undefined) {
        return
    }
    value= value.slice(0, 10)
    emit('update:modelValue', UtilCalendar.toIso(value))
}
</script>

<template>
    <ion-item>
        <ion-text>
            {{ label }}
        </ion-text>
        <div class="date-filter-button">
            <ion-datetime-button datetime="datetime"/>
        </div>
    </ion-item>
    <ion-modal :keep-contents-mounted="true">
        <ion-datetime
            :value="modelValue"
            id="datetime"
            presentation="date"
            :show-default-buttons="true"
            done-text="Ok"
            cancel-text="Fechar"
            @ionChange="updateValue($event.detail.value)"
        />
    </ion-modal>
</template>

<style scoped>
.date-filter-button {
    flex-grow: 1;
    justify-content: flex-end;
    display: flex;
}
</style>
