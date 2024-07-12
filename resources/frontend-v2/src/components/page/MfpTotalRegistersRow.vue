<script setup lang="ts">
import {IonLabel} from "@ionic/vue"

defineProps(
    {
        totalItens: {
            type: Number,
            required: true,
            default: 0
        }
    }
)
</script>

<template>
    <div class="ion-text-center ion-padding-top ion-padding-bottom">
        <ion-label>
            <p>
                Total de {{ totalItens }} registros
            </p>
        </ion-label>
    </div>
</template>
