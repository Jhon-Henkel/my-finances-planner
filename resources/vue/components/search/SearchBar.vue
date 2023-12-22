<template>
    <div class="input-group search-bar" style="">
        <span class="input-group-text" id="inputGroup-sizing-default">
            <font-awesome-icon :icon="iconEnum.search()" />
        </span>
        <input type="text" class="form-control" v-model="search" :placeholder="placeholder">
    </div>
</template>

<script>
import iconEnum from '~js/enums/iconEnum'

export default {
    name: 'MfpSearchBar',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    data() {
        return {
            search: ''
        }
    },
    props: {
        placeholder: {
            type: String,
            required: false,
            default: 'Buscar'
        }
    },
    emits: [
        'searchFor'
    ],
    watch: {
        search() {
            this.$emit('searchFor', this.search)
        }
    }
}
</script>

<style scoped>
    .search-bar {
        margin: 0 auto;
        max-width: 30%
    }
    @media (max-width: 768px) {
        .search-bar {
            max-width: 100%;
            margin-bottom: 10px;
        }
    }
</style>