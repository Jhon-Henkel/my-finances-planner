<script setup lang="ts">
import {IonCol, IonGrid, IonRow, IonImg, IonButton, IonLabel} from '@ionic/vue'
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import AppConfig from "@/infra/config/AppConfig"
import router from "../../infra/router"

const imageUrl = `${AppConfig.storageBaseUrl}in-development.gif`
</script>

<template>
    <mfp-page>
        <ion-row class="ion-align-items-center" style="height: 100vh;">
            <ion-col class="ion-no-padding">
                <ion-grid class="ion-no-padding">
                    <ion-row>
                        <ion-col class="ion-text-center">
                            <ion-img :src="imageUrl" alt="Em Desenvolvimento" class="ion-margin-bottom"/>
                            <ion-label>
                                <p>Essa tela ainda está em desenvolvimento, logo estará disponível!</p>
                            </ion-label>
                            <ion-button @click="router.push({name: 'dashboard'})" class="ion-margin-top">
                                Voltar para o dashboard
                            </ion-button>
                        </ion-col>
                    </ion-row>
                </ion-grid>
            </ion-col>
        </ion-row>
    </mfp-page>
</template>
