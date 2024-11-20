<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {ref} from "vue"
import {IonGrid, IonProgressBar} from "@ionic/vue"
import MfpFirstStep from "@/views/welcome/MfpFirstStep.vue"
import MfpSecondStep from "@/views/welcome/MfpSecondStep.vue"
import MfpFinalStep from "@/views/welcome/MfpFinalStep.vue"

const atualStage = ref(1)
const totalStages = 3
</script>

<template>
    <mfp-page>
        <ion-progress-bar :value="atualStage / totalStages"/>
        <ion-grid>
            <mfp-first-step v-if="atualStage === 1" @next-step="atualStage++"/>
            <mfp-second-step v-else-if="atualStage === 2" @next-step="atualStage++"/>
            <mfp-final-step v-else/>
        </ion-grid>
    </mfp-page>
</template>
