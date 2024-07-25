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
        <ion-col size="12" class="ion-text-end ion-no-padding">
            <ion-label class="ion-text-start">
                <ion-row class="vertical-center">
                    <ion-col size="2" class="ion-no-padding">
                        <ion-icon :icon="icon" :color="iconColor" class="icon"/>
                    </ion-col>
                    <ion-col size="5" class="ion-no-padding">
                        <ion-text>
                            {{ title }}
                        </ion-text>
                    </ion-col>
                    <ion-col size="5" class="ion-no-padding">
                        <ion-badge
                            v-if="useBadge"
                            :color="typeof value === 'number' && value > 0 ? 'success' : 'danger'"
                        >
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
                    </ion-col>
                </ion-row>
            </ion-label>
        </ion-col>
    </ion-row>
</template>

<style scoped>
.icon {
    font-size: 1.5em;
}
.vertical-center {
    display: flex;
    align-items: center;
}
</style>