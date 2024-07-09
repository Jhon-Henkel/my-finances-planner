<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"

defineProps(
    {
        filterPeriodLabel: {
            type: String,
            required: true
        }
    }
)
</script>

<template>
    <ion-item class="ion-text-center ion-margin-bottom ion-margin-top" lines="none">
        <ion-label>
            <strong>
                {{ filterPeriodLabel }}
            </strong>
        </ion-label>
    </ion-item>
</template>