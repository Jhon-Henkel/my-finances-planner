<template>
    <h3 class="title">{{ title }}</h3>
</template>

<script>
export default {
    name: 'MfpTitle',
    props: {
        title: {
            type: String,
            required: true,
            default: ''
        }
    }
}
</script>

<style scoped>
    .title {
        margin: auto 0 auto 0;
    }
    @media (max-width: 1000px) {
        .title {
            margin: auto auto 20px;
        }
    }
</style>