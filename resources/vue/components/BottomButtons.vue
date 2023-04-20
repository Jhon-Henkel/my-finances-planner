<template>
    <div class="nav justify-content-center">
        <router-link class="btn btn-danger rounded-5" :to="redirectTo">
            <font-awesome-icon :icon="buttonCancelIcon" class="me-2"/>
            {{ buttonCancelText }}
        </router-link>
        <button class="btn btn-success rounded-5 ms-3" @click="this.$emit('btn-clicked')">
            <font-awesome-icon :icon="buttonSuccessIcon" class="me-2" />
            {{ buttonSuccessText }}
        </button>
    </div>
</template>

<script>
    import iconEnum from "../../js/enums/iconEnum";

    export default {
        name: "BottomButtons",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        emits: [
            'btn-clicked'
        ],
        props: {
            buttonSuccessText: {
                type: String,
                required: true
            },
            buttonSuccessIcon: {
                type: Array,
                default: iconEnum.check()
            },
            buttonCancelText: {
                type: String,
                default: 'Cancelar'
            },
            buttonCancelIcon: {
                type: Array,
                default: iconEnum.xMark()
            },
            redirectTo: {
                type: String,
                required: true
            }
        }
    }
</script>