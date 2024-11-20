<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"

defineProps(
    {
        nothingToShow: {
            type: Boolean,
            required: true
        }
    }
)

</script>

<template>
    <ion-item v-if="nothingToShow" class="ion-text-center" lines="none">
        <ion-label>
            Ops... Nenhum item por aqui...
        </ion-label>
    </ion-item>
</template>