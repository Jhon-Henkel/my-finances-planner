<script setup lang="ts">
import {IonCol, IonRow, IonText} from "@ionic/vue"

defineProps({
    action: {
        type: String,
        required: true
    }
})

function openTermsOfUseModal() {
    console.log('openTermsOfUseModal')
}

function openPrivacyPolicyModal() {
    console.log('openPrivacyPolicyModal')
}
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="ion-text-center">
            <ion-text>
                Ao se <strong>{{ action }}</strong>, você concorda com os nossos <a href="#" @click="openTermsOfUseModal">
                Termos de Uso</a> e <a href="#" @click="openPrivacyPolicyModal">Política de Privacidade</a>.
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>
