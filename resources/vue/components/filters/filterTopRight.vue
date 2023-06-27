<template>
    <font-awesome-icon :icon="iconEnum.filterMoney()" class="me-2 mt-1 filter"/>
    <div class="form-group me-3">
        <select class="form-select form-select-sm" @change="callbackMethod($event)">
            <option v-for="item in filter" :key="item.id" :value="item.id">
                {{ item.label }}
            </option>
        </select>
    </div>
</template>

<script>
    import iconEnum from "../../../js/enums/iconEnum";

    export default {
        name: "filterTopRight",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        props: {
            filter: {
                type: Object,
                required: true
            }
        },
        emits: ["callbackMethod"],
        methods: {
            callbackMethod(event) {
                this.$emit("callbackMethod", event.target.value)
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .filter {
        font-size: 22px;
        color: $success-icon-color;
    }
</style>