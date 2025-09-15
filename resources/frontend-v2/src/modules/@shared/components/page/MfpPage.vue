<script setup lang="ts">
import {IonContent, IonPage} from "@ionic/vue"
</script>

<template>
    <ion-page class="ion-margin-top ion-padding-top">
        <ion-content :fullscreen="true">
            <slot/>
        </ion-content>
    </ion-page>
</template>
