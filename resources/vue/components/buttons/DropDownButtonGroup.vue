<template>
    <div class="btn-group">
        <button class="btn btn-success rounded-2 dropdown-toggle top-button"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <font-awesome-icon :icon="iconEnum.plus()" class="ms-2 me-2"/>
            Novo
        </button>
        <ul class="dropdown-menu">
            <li>

            </li>
            <li>
                <router-link-button title="Novo Gasto/Ganho"
                                    :icon="iconEnum.movement()"
                                    redirect-to="#"
                                    customClass="dropdown-item" />
            </li>
            <li>
                <router-link-button title="Nova Transferência"
                                    :icon="iconEnum.buildingColumns()"
                                    redirect-to="#"
                                    customClass="dropdown-item" />
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
        data() {
            return {
                buttonsData: [
                    {
                        title: 'Novo Gasto/Ganho',
                        icon: iconEnum.movement(),
                        redirectTo: '#'
                    },
                    {
                        title: 'Nova Transferência',
                        icon: iconEnum.buildingColumns(),
                        redirectTo: '#'
                    }
                ]
            }
        }
    }
</script>

<style scoped>

</style>