<script setup lang="ts">
import {IonContent, IonList} from "@ionic/vue"
</script>

<template>
    <ion-content>
        <ion-list :inset="true">
            <slot name="list"/>
        </ion-list>
        <slot name="content"/>
    </ion-content>
</template>