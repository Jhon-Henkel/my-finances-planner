<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonItem, IonList, IonRow, IonSkeletonText} from "@ionic/vue"
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
                    <ion-col size="1" class="ion-no-margin">
                        <ion-skeleton-text :animated="true" class="icon"/>
                    </ion-col>
                    <ion-col size="6" class="ion-no-margin">
                        <ion-row>
                            <ion-col>
                                <ion-skeleton-text :animated="true" class="text-size"/>
                            </ion-col>
                        </ion-row>
                        <ion-row>
                            <ion-col size="6" class="ion-no-margin">
                                <ion-skeleton-text :animated="true" class="text-size"/>
                            </ion-col>
                            <ion-col size="6" class="ion-no-margin">
                                <ion-skeleton-text :animated="true" class="text-size"/>
                            </ion-col>
                        </ion-row>
                    </ion-col>
                    <ion-col size="4" class="ion-no-margin">
                        <ion-skeleton-text :animated="true" class="text-size"/>
                    </ion-col>
                    <ion-col size="1" class="ion-text-end no-padding-end">
                        <ion-icon :icon="chevronBackOutline" class="animate-icon-left"/>
                    </ion-col>
                </ion-row>
            </ion-grid>
        </ion-item>
    </ion-list>
</template>

<style scoped>
.text-size {
    height: 10px;
}

.icon {
    height: 40px;
}
</style>