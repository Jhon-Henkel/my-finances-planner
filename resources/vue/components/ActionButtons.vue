<template>
    <div class="text-center action-buttons">
        <router-link class="btn btn-sm btn-info rounded-5 me-1"
                     :to="infoTo"
                     v-tooltip="infoTooltip"
                     v-show="showInfoButton">
            <font-awesome-icon :icon="infoIcon" />
        </router-link>
        <button class="btn btn-sm btn-success rounded-5 me-1"
                @click="this.$emit('check-clicked')"
                v-tooltip="checkTooltip"
                v-show="checkButton">
            <font-awesome-icon :icon="checkIcon" />
        </button>
        <router-link class="btn btn-sm btn-success rounded-5 me-1" :to="editTo" v-tooltip="tooltipEdit">
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
            'delete-clicked',
            'check-clicked'
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
            },
            showInfoButton: {
                type: Boolean,
                default: false
            },
            infoIcon: {
                type: Array,
                default: iconEnum.invoice()
            },
            infoTo: {
                type: String,
                default: ''
            },
            infoTooltip: {
                type: String,
                default: ''
            },
            checkButton: {
                type: Boolean,
                default: false
            },
            checkTooltip: {
                type: String,
                default: ''
            },
            checkIcon: {
                type: Array,
                default: iconEnum.check()
            }
        },
    }
</script>