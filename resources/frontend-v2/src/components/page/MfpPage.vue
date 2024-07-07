<script setup lang="ts">
import {IonContent, IonPage} from "@ionic/vue"
</script>

<template>
    <ion-page>
        <ion-content :fullscreen="true">
            <slot/>
        </ion-content>
    </ion-page>
</template>
