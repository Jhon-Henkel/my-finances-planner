<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonItem, IonList, IonRow, IonSkeletonText} from "@ionic/vue"
import {chevronBackOutline} from "ionicons/icons"

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
    <ion-list v-if="! store.isLoaded">
        <ion-item v-for="(item) in [1,2, 3]" :key="item">
            <ion-grid>
                <ion-row class="center-ion-label-content">
                    <ion-col size="11">
                        <ion-row>
                            <ion-col size="4">
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                            <ion-col size="4"/>
                            <ion-col size="4">
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                        </ion-row>
                        <ion-row>
                            <ion-col size="3">
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                            <ion-col size="6"/>
                            <ion-col size="3">
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                        </ion-row>
                        <ion-row>
                            <ion-col>
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                        </ion-row>
                        <ion-row>
                            <ion-col size="5">
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                            <ion-col size="3"/>
                            <ion-col size="4">
                                <ion-skeleton-text :animated="true"/>
                            </ion-col>
                        </ion-row>
                    </ion-col>
                    <ion-col size="1" class="ion-text-end no-padding-end">
                        <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-item>
    </ion-list>
</template>
