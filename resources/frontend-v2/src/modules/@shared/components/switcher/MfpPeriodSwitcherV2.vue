<script setup lang="ts">
import {IonButton, IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {chevronBackOutline, chevronForwardOutline} from "ionicons/icons"

defineProps(
    {
        store: {
            type: Object,
            required: true
        }
    }
)
</script>

<template>
    <ion-item class="ion-text-center ion-margin-bottom ion-margin-top" lines="none">
        <ion-grid>
            <ion-row>
                <ion-col size="1" class="center-ion-label-content">
                    <div class="ion-padding-start">
                        <ion-button @click="store.prevMonth()">
                            <ion-icon :icon="chevronBackOutline"/>
                        </ion-button>
                    </div>
                </ion-col>
                <ion-col size="10" class="center-ion-label-content">
                    <ion-label>
                        <strong>{{ store.dateLabel }}</strong>
                    </ion-label>
                </ion-col>
                <ion-col size="1" class="center-ion-label-content">
                    <div class="ion-padding-end">
                        <ion-button @click="store.nextMonth()">
                            <ion-icon :icon="chevronForwardOutline"/>
                        </ion-button>
                    </div>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
