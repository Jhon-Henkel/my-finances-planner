<script setup lang="ts">
import {IonContent, IonPage} from "@ionic/vue"
import {useAuthStore} from "@/stores/auth/AuthStore"

const authStore = useAuthStore()
</script>

<template>
    <ion-page class="ion-margin-top ion-padding-top">
        <ion-content :fullscreen="true">
            <div class="bg-danger ion-text-center" v-if="authStore?.user?.plan === 'Free'">
                <div class="padding-plan">
                    <p>Você está usando um plano gratuíto com limitações</p>
                </div>
            </div>
            <slot/>
        </ion-content>
    </ion-page>
</template>

<style scoped>
    .padding-plan {
        padding-top: 2px;
        padding-bottom: 2px;
    }
</style>
