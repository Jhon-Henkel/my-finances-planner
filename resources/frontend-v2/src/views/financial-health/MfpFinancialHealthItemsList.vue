<script setup lang="ts">
import {UtilMoney} from "@/util/UtilMoney"
import {PropType} from "vue"
import {IonItem, IonLabel, IonList} from "@ionic/vue"

const props = defineProps({
    items: {
        type: Array as PropType<{ name: string, value: number }[]>,
        required: true
    },
    totalValue: {
        type: Number,
        required: true
    },
    isExpense: {
        type: Boolean,
        required: true
    }
})

function getPercentage(value: number): string {
    return ((value / props.totalValue) * 100).toFixed(2)
}
</script>

<template>
    <ion-list v-for="(item, index) in items" :key="index">
        <ion-item>
            <ion-label>{{ item.name }}</ion-label>
            <ion-label>{{ UtilMoney.formatValueToBr(item.value) }}</ion-label>
            <ion-label slot="end">{{ getPercentage(item.value) }} %</ion-label>
        </ion-item>
    </ion-list>
</template>