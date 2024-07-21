<script setup lang="ts">
import {IonItem, IonLabel, IonList, IonSkeletonText} from "@ionic/vue"
</script>

<template>
    <ion-list v-for="(item) in [1,2,3,4,5]" :key="item">
        <ion-item>
            <ion-label>
                <ion-skeleton-text :animated="true"/>
            </ion-label>
            <ion-label>
                <ion-skeleton-text :animated="true"/>
            </ion-label>
            <ion-label slot="end">
                <ion-skeleton-text :animated="true"/>
            </ion-label>
        </ion-item>
    </ion-list>
</template>