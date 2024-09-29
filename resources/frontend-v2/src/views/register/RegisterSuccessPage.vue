<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonLabel, IonRow, IonText} from "@ionic/vue"
import {checkmarkCircleOutline, chevronForward} from "ionicons/icons"
import MfpPage from "@/components/page/MfpPage.vue"

const urlParams = new URLSearchParams(window.location.search)
const email = urlParams.get('email')
</script>

<template>
    <mfp-page>
        <ion-grid>
            <ion-row class="first-item">
                <ion-col size="1"/>
                <ion-col size="10">
                    <ion-icon :icon="checkmarkCircleOutline" class="icon"/>
                </ion-col>
                <ion-col size="1"/>
            </ion-row>
            <ion-row class="ion-padding-bottom">
                <ion-col size="1"/>
                <ion-col size="10">
                    <ion-text color="primary">
                        <h1>Registrado com sucesso!</h1>
                    </ion-text>
                </ion-col>
                <ion-col size="1"/>
            </ion-row>
            <ion-row>
                <ion-col size="1"/>
                <ion-col size="10">
                    <ion-icon :icon="chevronForward" color="primary"/>
                    <ion-text>Em breve você receberá um e-mail para confirmar o seu registro.</ion-text>
                    <br><br>
                    <ion-icon :icon="chevronForward" color="primary"/>
                    <ion-text>Se não receber o e-mail, verifique a caixa de spam ou a lixeira.</ion-text>
                    <br><br>
                    <ion-icon :icon="chevronForward" color="primary"/>
                    <ion-text>O login só poderá ser feito após receber o e-mail de confirmação.</ion-text>
                    <br><br>
                    <ion-text>E-mail registrado:
                        <ion-label color="primary">
                            {{ email }}
                        </ion-label>
                    </ion-text>
                </ion-col>
                <ion-col size="1"/>
            </ion-row>
        </ion-grid>
    </mfp-page>
</template>

<style scoped>
.icon {
    width: 100%;
    font-size: 200px;
    color: var(--ion-color-success);
}

.first-item {
    margin-top: 100px;
}
</style>
