<script setup lang="ts">
import {IonCol, IonGrid, IonItem, IonRow, IonSkeletonText} from "@ionic/vue"
</script>

<template>
    <ion-item v-for="(item) in [1,2,3,4,5]" :key="item">
        <ion-grid>
            <ion-row class="center-ion-label-content">
                <ion-col size="1">
                    <ion-skeleton-text :animated="true"/>
                </ion-col>
                <ion-col>
                    <ion-skeleton-text :animated="true"/>
                </ion-col>
                <ion-col class="ion-text-end">
                    <ion-skeleton-text :animated="true"/>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
