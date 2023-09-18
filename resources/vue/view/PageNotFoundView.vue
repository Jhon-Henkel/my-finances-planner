<template>
    <div id="not-found-page">
        <img src="/public/images/moneyFlying.png" alt="image for money flying" id="money-flying">
        <h1>Hum... Parece que a pagina que você procura está voando por ai...</h1>
        <h2>Tente outra página! (Erro 404)</h2>
    </div>
</template>

<script>
export default {
    name: 'PageNotFoundView'
}
</script>

<style scoped>
    #not-found-page {
        text-align: center;
        margin-top: 150px;
    }
    #money-flying {
        margin-bottom: 20px;
        width: 250px;
        height: 250px;
    }
</style>