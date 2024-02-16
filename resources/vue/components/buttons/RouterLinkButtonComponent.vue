<template>
    <router-link :class="customClass" :to="redirectTo">
        <font-awesome-icon :icon="icon" class="me-2"/>
        <slot/>
    </router-link>
</template>

<script>
export default {
    name: 'MfpRouterLinkButton',
    props: {
        redirectTo: {
            type: String,
            required: true
        },
        icon: {
            type: Array,
            required: true
        },
        customClass: {
            type: String,
            default: 'btn btn-success rounded-2'
        }
    }
}
</script>