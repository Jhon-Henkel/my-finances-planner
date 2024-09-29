<script setup lang="ts">
import {IonCol, IonRow} from "@ionic/vue"

defineProps({
    colClass: {
        type: String,
        required: false,
    },
    rowClass: {
        type: String,
        required: false,
    },
})
</script>

<template>
    <ion-row :class="rowClass">
        <ion-col size="1"/>
        <ion-col size="10" :class="colClass">
            <slot/>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>
