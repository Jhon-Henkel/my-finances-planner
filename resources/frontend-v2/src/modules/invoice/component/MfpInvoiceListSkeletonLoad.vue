<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonList, IonRow, IonSkeletonText} from "@ionic/vue"
import {chevronBackOutline} from "ionicons/icons"

defineProps(
    {
        isLoaded: {
            type: Boolean,
            required: true
        }
    }
)
</script>

<template>
    <ion-list v-if="! isLoaded">
        <ion-item v-for="(item) in [1,2,3,4,5]" :key="item">
            <ion-grid>
                <ion-row class="center-ion-label-content">
                    <ion-col size="1">
                        <ion-skeleton-text :animated="true" class="skeleton-load-size"/>
                    </ion-col>
                    <ion-col size="6">
                        <ion-row>
                            <ion-col size="6" class="ion-padding-start">
                                <ion-label>
                                    <ion-skeleton-text :animated="true" class="skeleton-load-size"/>
                                </ion-label>
                            </ion-col>
                        </ion-row>
                        <ion-row>
                            <ion-col class="ion-padding-start">
                                <ion-skeleton-text :animated="true" class="skeleton-load-size"/>
                            </ion-col>
                        </ion-row>
                    </ion-col>
                    <ion-col size="4" class="ion-text-end">
                        <ion-skeleton-text :animated="true" class="skeleton-load-size"/>
                    </ion-col>
                    <ion-col size="1" class="ion-text-end no-padding-end">
                        <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-item>
    </ion-list>
</template>
