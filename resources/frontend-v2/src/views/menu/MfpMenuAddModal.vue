<script setup lang="ts">
import {IonModal} from "@ionic/vue"

const modalBreakpoints: Array<number> = [0, 0.85]
</script>

<template>
    <ion-modal
        trigger="mfp-tab-plus-modal"
        :initial-breakpoint="modalBreakpoints[1]"
        :breakpoints="modalBreakpoints"
        handle-behavior="cycle"
    >
        <h1 class="ion-text-center">Em Desenvolvimento</h1>
    </ion-modal>
</template>