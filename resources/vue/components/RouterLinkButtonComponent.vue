<template>
    <router-link class="btn btn-success rounded-2" :to="redirectTo">
        <font-awesome-icon :icon="icon" class="me-2"/>
        {{ title }}
    </router-link>
</template>

<script>
    export default {
        name: "RouterLinkButton",
        props: {
            redirectTo: {
                type: String,
                required: true
            },
            title: {
                type: String,
                required: true
            },
            icon: {
                type: Array,
                required: true
            }
        }
    }
</script>