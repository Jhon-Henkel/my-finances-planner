<template>
    <router-link class="btn btn-success rounded-2" :to="to">
        <font-awesome-icon :icon="iconEnum.back()" class="me-2"/>
        Voltar
    </router-link>
</template>

<script>
import iconEnum from '../../../js/enums/iconEnum'

export default {
    name: 'BackButton',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    props: {
        to: {
            type: String,
            required: true
        }
    }
}
</script>