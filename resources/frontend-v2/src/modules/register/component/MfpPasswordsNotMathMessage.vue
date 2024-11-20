<script setup lang="ts">
import {IonRow, IonCol, IonText} from "@ionic/vue"
import {PropType} from "vue"
import {IRegisterForm} from '@/modules/register/service/IRegisterForm'

defineProps({
    registerData: {
        type: Object as PropType<IRegisterForm>,
        required: true
    }
})
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10">
            <ion-text color="danger" v-if="registerData.password != registerData.confirmPassword">
                As senhas não estão iguais!
            </ion-text>
            <ion-col size="1"/>
        </ion-col>
    </ion-row>
</template>
