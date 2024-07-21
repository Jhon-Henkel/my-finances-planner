<script setup lang="ts">
import {IonButton, IonIcon} from "@ionic/vue"
import {personCircleOutline} from "ionicons/icons"
</script>

<template>
    <ion-button class="ion-no-padding ion-margin-end" expand="block">
        <ion-icon :icon="personCircleOutline" class="top-icon"/>
    </ion-button>
</template>