<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message"/>
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">#### ALTERAR ####</h3>
                <router-link class="btn btn-success rounded-5" to="/movimentacoes/cadastrar">
                    <font-awesome-icon :icon="iconEnum.sackDollar()" class="me-2"/>
                    #### ALTERAR ####
                </router-link>
            </div>
            <hr class="mb-4">
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                <tr class="text-center">
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center">
                    <td></td>
                    <td>
                        <action-buttons
                            :delete-tooltip="'Deletar #### ALTERAR ####'"
                            :tooltip-edit="'Editar #### ALTERAR ####'"
                            :edit-to="'#### ALTERAR ####'"
                            @delete-clicked="'#### ALTERAR ####'" />
                    </td>
                </tr>
                </tbody>
            </table>
            <hr class="mt-4">
        </div>
    </div>
</template>

<script>
    import Message from "../../components/MessageComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import CalendarTools from "../../../js/tools/calendarTools";
    import ActionButtons from "../../components/ActionButtons.vue";

    export default {
        name: '#### ALTERAR ####',
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            ActionButtons,
            LoadingComponent,
            Message
        },
        data() {
            return {
                loadingDone: false,
                message: null,
                messageType: null,
                messageTimeOut: CalendarTools.fiveSecondsTimeInMs()
            }
        },
        methods: {
            resetMessage() {
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
        }
    }
</script>

<style scoped>

</style>