<script setup lang="ts">
import {IonContent, IonPage} from "@ionic/vue"
</script>

<template>
    <ion-page>
        <ion-content :fullscreen="true" class="ion-margin-top ion-padding-top">
            <slot/>
        </ion-content>
    </ion-page>
</template>
