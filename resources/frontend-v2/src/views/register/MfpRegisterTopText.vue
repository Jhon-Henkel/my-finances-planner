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
                        É bom ter você aqui!
                    </strong>
                </h1>
            </ion-text>
        </ion-col>
        <ion-col size="1"/>
    </ion-row>
    <ion-row>
        <ion-col size="1"/>
        <ion-col size="10" class="create-account-box">
            <ion-text class="text-insert-data">
                Insira os dados
            </ion-text>
            <br>
            <ion-text class="text-new-account">
                Para criar uma nova conta!
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

.create-account-box {
    margin-bottom: 20px;
}

.text-insert-data {
    font-size: 1.5em;
}

.text-new-account {
    font-size: 1em;
}
</style>
