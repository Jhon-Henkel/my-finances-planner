<script setup lang="ts">
import {IonContent, IonList, IonItem} from "@ionic/vue"

defineProps(
    {
        showContent: {
            type: Boolean,
            required: false,
            default: false
        }
    }
)
</script>

<template>
    <ion-content>
        <ion-list :inset="true">
            <slot name="list"/>
        </ion-list>
        <ion-list :inset="true" v-if="showContent">
            <ion-item>
                <slot name="content"/>
            </ion-item>
        </ion-list>
    </ion-content>
</template>