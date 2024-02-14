<template>
    <div class="btn-group">
        <button class="btn btn-success dropdown-toggle top-button margin-mobile"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <font-awesome-icon :icon="dropdownIcon" class="me-2 icon"/>
            {{ dropdownTitle }}
        </button>
        <ul class="dropdown-menu">
            <li v-for="(button, index) in buttonsArray" :key="index">
                <div :class="alignItensCenter ? 'text-center' : ''">
                    <mfp-router-link-button :icon="button.icon" :redirect-to="button.redirectTo" customClass="dropdown-item" >
                        {{ button.title }}
                    </mfp-router-link-button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import iconEnum from '~js/enums/iconEnum'
import MfpRouterLinkButton from '~vue-component/buttons/RouterLinkButtonComponent.vue'

export default {
    name: 'MfpDropDownButton',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        MfpRouterLinkButton
    },
    props: {
        dropdownTitle: {
            type: String,
            required: false,
            default: 'Novo'
        },
        dropdownIcon: {
            type: Array,
            required: false,
            default: iconEnum.plus
        },
        buttonsArray: {
            type: Array,
            required: true
        },
        alignItensCenter: {
            type: Boolean,
            required: false,
            default: true
        }
    }
}
</script>

<style scoped>
    @media (max-width: 1000px) {
        .icon {
            display: none;
        }
        .margin-mobile {
            margin-top: 10px !important;
        }
        .dropdown-menu {
            width: 100%;
            padding: 10px;
            margin-left: 1%;
            margin-right: 1%;
        }
    }
    .btn {
        top: 0%;
    }
</style>