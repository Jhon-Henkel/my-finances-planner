<script setup lang="ts">
import {IonCol, IonRow, IonText} from "@ionic/vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpTermsOfUseModal from "@/modules/terms-and-policy/MfpTermsOfUseModal.vue"
import MfpPrivacyPolicyModal from "@/modules/terms-and-policy/MfpPrivacyPolicyModal.vue"

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
                Ao <strong>{{ action }}</strong>, você concorda com os nossos
                <a class="no-break" @click="openTermsOfUseModal">Termos de Uso</a> e
                <a class="no-break" @click="openPrivacyPolicyModal">Política de Privacidade</a>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>
