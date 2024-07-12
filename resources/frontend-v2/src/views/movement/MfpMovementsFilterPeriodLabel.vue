<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"
import {useMovementStore} from "@/stores/movement/MovementStore"
import {MovementService} from "@/services/movement/MovementService"

defineProps(
    {
        filterPeriodLabel: {
            type: String,
            required: true
        }
    }
)

const store = useMovementStore()
</script>

<template>
    <ion-item class="ion-text-center ion-margin-bottom ion-margin-top" lines="none">
        <ion-label>
            <strong>
                {{MovementService.geLabelForMovementType(store.lastMovementFilterType) }} {{filterPeriodLabel}}
            </strong>
        </ion-label>
    </ion-item>
</template>