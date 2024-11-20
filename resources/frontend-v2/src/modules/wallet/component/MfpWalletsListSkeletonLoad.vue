<script setup lang="ts">
import {IonCol, IonGrid, IonItem, IonLabel, IonList, IonRow, IonSkeletonText} from "@ionic/vue"

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
                <ion-row class="ion-row">
                    <ion-col>
                        <ion-row>
                            <ion-col size="6">
                                <ion-label>
                                    <ion-skeleton-text :animated="true" style="height: 15px"/>
                                </ion-label>
                            </ion-col>
                            <ion-col size="5">
                                <ion-label>
                                    <ion-skeleton-text :animated="true" style="height: 15px"/>
                                </ion-label>
                            </ion-col>
                        </ion-row>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-item>
    </ion-list>
</template>
