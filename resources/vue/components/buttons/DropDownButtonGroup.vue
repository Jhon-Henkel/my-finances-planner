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
                <div class="text-center">
                    <router-link-button :title="button.title"
                                        :icon="button.icon"
                                        :redirect-to="button.redirectTo"
                                        customClass="dropdown-item" />
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import iconEnum from '~js/enums/iconEnum'
import RouterLinkButton from '~vue-component/RouterLinkButtonComponent.vue'

export default {
    name: 'MfpDropDownButton',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        RouterLinkButton
    },
    props: {
        dropdownTitle: {
            type: String,
            required: true
        },
        dropdownIcon: {
            type: Array,
            required: true
        },
        buttonsArray: {
            type: Array,
            required: true
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