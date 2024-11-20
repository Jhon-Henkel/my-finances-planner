<script setup lang="ts">
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import AppConfig from "@/infra/config/AppConfig"

const imageUrl = `${AppConfig.storageBaseUrl}updating.gif`
</script>

<template>
    <mfp-page>
        <ion-content class="ion-padding">
            <div class="update-container">
                <ion-img :src="imageUrl" alt="Atualizando" class="ion-margin-bottom"/>
                <h1>Atualizando!</h1>
                <p>Voltamos em alguns instantes...</p>
            </div>
        </ion-content>
    </mfp-page>
</template>

<style scoped>
.update-container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    text-align: center;
}
</style>
