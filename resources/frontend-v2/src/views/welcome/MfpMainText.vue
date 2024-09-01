<script setup lang="ts">
import {IonCol, IonRow, IonText} from "@ionic/vue"
</script>

<template>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="finances-control-text">
            <ion-text class="text-1">
                Comece a ter
                <ion-text color="primary">
                    <strong>
                        controle
                    </strong>
                </ion-text>
            </ion-text>
            <br>
            <ion-text class="text-2">
                sobre sua
                <ion-text color="primary">
                    <strong>
                        vida financeira!
                    </strong>
                </ion-text>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
</template>

<style scoped>
.finances-control-text {
    margin-bottom: 20px;
}

.text-1 {
    font-size: 1.5em;
}

.text-2 {
    font-size: 1em;
}
</style>
