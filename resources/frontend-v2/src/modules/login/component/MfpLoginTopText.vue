<script setup lang="ts">
import {IonCol, IonRow, IonText} from "@ionic/vue"
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="text-welcome">
            <ion-text color="primary">
                <h1>
                    <strong>
                        Bem vindo!
                    </strong>
                </h1>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="do-login-box">
            <ion-text class="text-please">
                Por favor
            </ion-text>
            <br>
            <ion-text class="text-do-login">
                Faça o login para continuar...
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>

<style scoped>
.text-welcome {
    margin-top: 50px;
    margin-bottom: 20px;
}

.do-login-box {
    margin-bottom: 20px;
}

.text-please {
    font-size: 1.5em;
}

.text-do-login {
    font-size: 1em;
}
</style>