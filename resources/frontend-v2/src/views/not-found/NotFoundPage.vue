<script setup lang="ts">
import {IonButton} from '@ionic/vue'
</script>

<template>
    <div class="not-found-container">
        <h1>Oops!</h1>
        <p>Parece que a página que você está procurando não existe.</p>
        <ion-button href="/v2/dashboard">Voltar para a Dashboard</ion-button>
    </div>
</template>

<style scoped>
.not-found-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    text-align: center;
}

h1 {
    font-size: 2em;
    color: #333;
}

p {
    color: #666;
}

a {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
}
</style>