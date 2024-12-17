<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {MovementService} from "@/modules/movement/service/MovementService"
import {MovementModel} from "@/modules/movement/model/MovementModel"
import {chevronBackOutline} from "ionicons/icons"

defineProps(
    {
        movement: {
            type: MovementModel,
            required: true
        }
    }
)
</script>

<template>
    <ion-item>
        <ion-grid>
            <ion-row class="center-ion-label-content">
                <ion-col size="1">
                    <ion-icon
                        :icon="MovementService.getIconForMovementType(movement.type)"
                        :color="MovementService.getColorForMovementType(movement.type)"
                        class="icon"
                    />
                </ion-col>
                <ion-col size="6">
                    <ion-row>
                        <ion-col>
                            <ion-label class="no-break text-truncate">
                                <strong>
                                    {{ movement.description }}
                                </strong>
                            </ion-label>
                        </ion-col>
                    </ion-row>
                    <ion-row>
                        <ion-col size="6">
                            <ion-label>
                                {{ UtilCalendar.formatStringToBr(movement.createdAt) }}
                            </ion-label>
                        </ion-col>
                        <ion-col size="6">
                            <ion-label class="no-break text-truncate">
                                {{ movement.walletName }}
                            </ion-label>
                        </ion-col>
                    </ion-row>
                </ion-col>
                <ion-col size="4" class="ion-text-end">
                    <ion-label>
                        {{ UtilMoney.formatValueToBr(movement.amount) }}
                    </ion-label>
                </ion-col>
                <ion-col size="1" class="ion-text-end no-padding-end">
                    <ion-icon :icon="chevronBackOutline" class="animate-icon-left" />
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>

<style scoped>
.icon {
    font-size: 2.1em;
}
</style>
