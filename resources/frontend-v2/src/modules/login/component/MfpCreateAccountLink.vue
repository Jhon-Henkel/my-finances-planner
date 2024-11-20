<script setup lang="ts">
import {IonCol, IonLabel, IonRow} from "@ionic/vue"
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="ion-text-center">
            <ion-label>
                Novo no App?
                <router-link to="/v2/registrar-se" class="link">
                    Crie uma conta
                </router-link>
            </ion-label>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>
