<script setup lang="ts">
import {IonLabel} from "@ionic/vue"

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
    <div class="ion-text-center ion-padding-top ion-padding-bottom">
        <ion-label>
            <p>
                Total de {{ store.pageTotalItems }} registros
            </p>
        </ion-label>
    </div>
</template>
