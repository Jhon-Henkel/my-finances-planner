<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"
import {useMovementStore} from "@/modules/movement/store/MovementStore"
import {MovementService} from "@/modules/movement/service/MovementService"

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
