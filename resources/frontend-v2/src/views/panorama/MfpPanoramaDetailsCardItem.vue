<script setup lang="ts">
import {IonCol, IonRow, IonText, IonIcon, IonLabel} from "@ionic/vue"
import MfpCounterMoney from "@/components/counter/MfpCounterMoney.vue"

defineProps({
    value: {
        type: [Number, String],
        required: true
    },
    icon: {
        type: String,
        required: true
    },
    iconColor: {
        type: String,
        required: true
    },
    title: {
        type: String,
        required: true
    }
})
</script>

<template>
    <ion-row>
        <ion-col size="12" class="ion-text-end">
            <ion-label class="center-ion-label-content">
                <ion-icon :icon="icon" :color="iconColor" class="icon"/>
                <ion-text class="ion-margin-end">
                    {{ title }}
                </ion-text>
                <mfp-counter-money :end="value" v-if="typeof value === 'number'"/>
                <ion-text v-else>
                    {{ value }}
                </ion-text>
            </ion-label>
        </ion-col>
    </ion-row>
</template>

<style scoped>
.icon {
    font-size: 1.5em;
    margin-right: 10px;
}
</style>