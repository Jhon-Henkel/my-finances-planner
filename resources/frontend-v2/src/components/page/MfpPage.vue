<script setup lang="ts">
import {IonContent, IonPage, IonRow, IonCol, IonGrid, IonBadge} from "@ionic/vue"
import {useAuthStore} from "@/stores/auth/AuthStore"

const authStore = useAuthStore()
</script>

<template>
    <ion-page class="ion-margin-top ion-padding-top">
        <ion-content :fullscreen="true">
            <ion-grid>
                <ion-row>
                    <ion-col>
                        <ion-badge color="danger" v-if="authStore?.user?.plan === 'Free'" class="full-width-badge">
                            Você está usando um plano gratuíto
                        </ion-badge>
                    </ion-col>
                </ion-row>
            </ion-grid>
            <slot/>
        </ion-content>
    </ion-page>
</template>
