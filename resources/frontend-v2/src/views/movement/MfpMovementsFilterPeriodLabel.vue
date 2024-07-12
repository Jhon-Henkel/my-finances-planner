<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"
import {useMovementStore} from "@/stores/movement/MovementStore"
import {MovementService} from "@/services/movement/MovementService"

const store = useMovementStore()
</script>

<template>
    <ion-item class="ion-text-center ion-margin-bottom ion-margin-top" lines="none">
        <ion-label>
            <strong>
                {{MovementService.geLabelForMovementType(store.lastMovementFilterType) }} {{store.dateOfResults}}
            </strong>
        </ion-label>
    </ion-item>
</template>