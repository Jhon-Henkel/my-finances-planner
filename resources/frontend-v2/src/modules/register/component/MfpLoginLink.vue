<script setup lang="ts">
import {IonCol, IonLabel, IonRow} from "@ionic/vue"
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="ion-text-center">
            <ion-label>
                Já tem uma conta?
                <router-link to="/v2/login" class="link">Faça o login</router-link>
            </ion-label>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>
