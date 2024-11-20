<script setup lang="ts">
import {IonButton, IonIcon} from "@ionic/vue"
import {addCircleOutline} from "ionicons/icons"
</script>

<template>
    <ion-button class="ion-no-padding ion-margin-end" expand="block">
        <ion-icon :icon="addCircleOutline" class="top-icon"/>
    </ion-button>
</template>