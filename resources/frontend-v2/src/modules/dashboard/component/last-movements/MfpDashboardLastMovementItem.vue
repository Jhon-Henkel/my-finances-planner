<script setup lang="ts">
import {useMovementStore} from "@/modules/movement/store/MovementStore"
import {onMounted} from "vue"
import {IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {MovementService} from "@/modules/movement/service/MovementService"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {UtilString} from "@/modules/@shared/util/UtilString"

const movementStore = useMovementStore()

onMounted(async () => {
    if (!movementStore.isLoaded) {
        await movementStore.loadMovements()
    }
})
</script>

<template>
    <ion-item v-for="movement in movementStore.thisMonthMovements.slice(0, 5)" :key="movement.id">
        <ion-grid>
            <ion-row class="center-ion-label-content">
                <ion-col size="1">
                    <ion-icon
                        :icon="MovementService.getIconForMovementType(movement.type)"
                        :color="MovementService.getColorForMovementType(movement.type)"
                        class="icon"
                    />
                </ion-col>
                <ion-col size="col-4">
                    <ion-label>
                        {{ UtilCalendar.formatStringToBrOnlyDayAndMonth(movement.createdAt) }}
                    </ion-label>
                </ion-col>
                <ion-col>
                    <ion-label class="ion-text-start no-break">
                        {{ UtilString.ellipsis(movement.description, 10) }}
                    </ion-label>
                </ion-col>
                <ion-col class="ion-text-end">
                    <ion-label>
                        {{ UtilMoney.formatValueToBr(movement.amount) }}
                    </ion-label>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
