<script setup lang="ts">
import {IonCol, IonRow, IonText, IonIcon, IonLabel, IonBadge} from "@ionic/vue"
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
    },
    useBadge: {
        type: Boolean,
        default: false
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
                <ion-badge v-if="useBadge" :color="value > 0 ? 'success' : 'danger'">
                    <mfp-counter-money :end="value" v-if="typeof value === 'number'"/>
                    <ion-text v-else>
                        {{ value }}
                    </ion-text>
                </ion-badge>
                <ion-text v-else>
                    <mfp-counter-money :end="value" v-if="typeof value === 'number'"/>
                    <ion-text v-else>
                        {{ value }}
                    </ion-text>
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