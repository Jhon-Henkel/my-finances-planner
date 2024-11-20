<script setup lang="ts">
import {IonButton, IonIcon} from "@ionic/vue"
import {filterCircleOutline} from "ionicons/icons"
</script>

<template>
    <ion-button class="ion-no-padding" expand="block">
        <ion-icon :icon="filterCircleOutline" class="top-icon"/>
    </ion-button>
</template>