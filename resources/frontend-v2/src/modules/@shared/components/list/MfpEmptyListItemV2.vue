<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"

defineProps(
    {
        store: {
            type: Object,
            required: true
        }
    }
)

</script>

<template>
    <div class="ion-padding-top">
        <ion-item v-if="store.pageTotalItems === 0 && store.isLoaded" class="ion-text-center" lines="none">
            <ion-label>
                Ops... Nenhum item por aqui...
            </ion-label>
        </ion-item>
    </div>
</template>
