<script setup lang="ts">
import {IonCol, IonRow, IonText} from "@ionic/vue"
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="ion-text-end">
            <ion-text>
                <router-link to="/v2/em-breve" class="link">
                    Esqueceu a senha?
                </router-link>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>