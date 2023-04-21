<template>
    <div class="text-center action-buttons">
        <router-link class="btn btn-sm btn-success rounded-5 me-1"
                     :to="editTo"
                     v-tooltip="tooltipEdit">
            <font-awesome-icon :icon="editIcon" />
        </router-link>
        <button class="btn btn-sm btn-danger rounded-5"
                @click="this.$emit('delete-clicked')"
                v-tooltip="deleteTooltip">
            <font-awesome-icon :icon="deleteIcon" />
        </button>
    </div>
</template>

<script>
    import iconEnum from "../../js/enums/iconEnum";

    export default {
        name: "ActionButtons",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        emits: [
            'delete-clicked'
        ],
        props: {
            editTo: {
                type: String,
                required: true
            },
            editIcon: {
                type: Array,
                default: iconEnum.editIcon()
            },
            tooltipEdit: {
                type: String,
                required: true
            },
            deleteIcon: {
                type: Array,
                default: iconEnum.trashIcon()
            },
            deleteTooltip: {
                type: String,
                required: true
            }
        },
    }
</script>

<style scoped>

</style>