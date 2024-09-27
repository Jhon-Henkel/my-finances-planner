<script setup lang="ts">
import {IonCol, IonRow, IonText} from "@ionic/vue"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpTermsOfUseModal from "@/views/terms-and-policy/MfpTermsOfUseModal.vue"
import MfpPrivacyPolicyModal from "@/views/terms-and-policy/MfpPrivacyPolicyModal.vue"

defineProps({
    action: {
        type: String,
        required: true
    }
})

function openTermsOfUseModal() {
    const termsModal = new MfpModal(MfpTermsOfUseModal)
    termsModal.open()
}

function openPrivacyPolicyModal() {
    const privacyModal = new MfpModal(MfpPrivacyPolicyModal)
    privacyModal.open()
}
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="ion-text-center">
            <ion-text>
                Ao se <strong>{{ action }}</strong>, você concorda com os nossos <a @click="openTermsOfUseModal">
                Termos de Uso</a> e <a @click="openPrivacyPolicyModal">Política de Privacidade</a>.
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>
