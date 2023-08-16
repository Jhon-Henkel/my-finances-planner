<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Movimentações"/>
                <filter-top-right :filter="filterList" @callbackMethod="getMovementIndexFiltered($event)"/>
                <router-link-button title="Novo Gasto/Ganho"
                                    :icon="iconEnum.movement()"
                                    :redirect-to="newGainSpentLink"
                                    class="top-button me-2"/>
                <router-link-button title="Nova Transferência"
                                    :icon="iconEnum.buildingColumns()"
                                    :redirect-to="newTransferLink"
                                    class="top-button"/>
            </div>
            <divider/>
            <div class="table-responsive-lg">
                <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                    <thead class="table-dark">
                        <tr class="text-center">
                            <th></th>
                            <th scope="col">Descrição</th>
                            <th scope="col">Carteira</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Data</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr v-show="movements.length === 0">
                            <td colspan="8">Nenhuma movimentação cadastrada ainda!</td>
                        </tr>
                        <tr v-for="movement in movements" :key="movement.id">
                            <td>
                                <font-awesome-icon v-if="movement.type === movementEnum.type.transfer()"
                                                   :icon="iconEnum.circleArrowRight()"
                                                   class="movement-transfer-icon"/>
                                <font-awesome-icon v-else-if="movement.type === movementEnum.type.spent()"
                                                   :icon="iconEnum.circleArrowDown()"
                                                   class="movement-spent-icon"/>
                                <font-awesome-icon v-else-if="movement.type === movementEnum.type.gain()"
                                                   :icon="iconEnum.circleArrowUp()"
                                                   class="movement-gain-icon"/>
                            </td>
                            <td>{{ movement.description }}</td>
                            <td>{{ movement.walletName }}</td>
                            <td>{{ stringTools.formatFloatValueToBrString(movement.amount) }}</td>
                            <td>{{ calendarTools.convertDateDbToBr(movement.createdAt) }}</td>
                            <td>
                                <action-buttons
                                    v-if="movement.type !== movementEnum.type.transfer()"
                                    :delete-tooltip="'Deletar Movimentação'"
                                    :tooltip-edit="'Editar Movimentação'"
                                    :edit-to="'/movimentacoes/' + movement.id + '/atualizar'"
                                    @delete-clicked="deleteMovement(movement.id, movement.description)"/>
                                <div class="text-center action-buttons" v-if="movement.type === movementEnum.type.transfer()">
                                    <button class="btn btn-sm btn-danger rounded-5 text-center action-buttons delete-button"
                                            @click="deleteTransfer(movement.id, movement.description)"
                                            v-tooltip="'Deletar Movimentação'" >
                                        <font-awesome-icon :icon="iconEnum.trashIcon()" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row ms-1">
                <div class="card glass success balance-card">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.movement()" class="me-2"/>
                            Resumo
                        </h4>
                        <hr>
                        <div class="card-text resume-content">
                            <div class="row">
                                <div class="col-4">
                                    <h6>
                                        <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="movement-gain-icon"/>
                                        Ganhos
                                    </h6>
                                </div>
                                <div class="col-4">
                                    <h6>
                                        <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="movement-spent-icon"/>
                                        Gastos
                                    </h6>
                                </div>
                                <div class="col-4">
                                    <h6>
                                        <font-awesome-icon :icon="iconEnum.scaleBalanced()"/>
                                        Balanço
                                    </h6>
                                </div>
                            </div>
                            <div class="row resume-value">
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(totalGain) }}
                                    <alert-icon v-if="totalGain < 0"/>
                                </div>
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(totalSpent) }}
                                    <alert-icon v-if="totalSpent < 0"/>
                                </div>
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(balance) }}
                                    <alert-icon v-if="balance < 0"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import ActionButtons from "../../components/ActionButtons.vue";
    import MovementEnum from "../../../js/enums/movementEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import stringTools from "../../../js/tools/stringTools";
    import calendarTools from "../../../js/tools/calendarTools";
    import movementEnum from "../../../js/enums/movementEnum";
    import numberTools from "../../../js/tools/numberTools";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";
    import StringTools from "../../../js/tools/stringTools";
    import AlertIcon from "../../components/AlertIcon.vue";
    import FilterTopRight from "../../components/filters/filterTopRight.vue";
    import RouterLinkButton from "../../components/RouterLinkButtonComponent.vue";

    export default {
        name: "MovementView",
        computed: {
            StringTools() {
                return StringTools
            },
            movementEnum() {
                return movementEnum
            },
            calendarTools() {
                return calendarTools
            },
            stringTools() {
                return stringTools
            },
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            RouterLinkButton,
            FilterTopRight,
            AlertIcon,
            MfpMessage,
            MfpTitle,
            Divider,
            ActionButtons,
            LoadingComponent,
        },
        data() {
            return {
                loadingDone: false,
                movements: {},
                filterList: {},
                totalSpent: 0,
                totalGain: 0,
                balance: 0,
                lastFilter: null,
                newGainSpentLink: '/movimentacoes/cadastrar',
                newTransferLink: '/movimentacoes/transferir',
            }
        },
        methods: {
            async deleteMovement(id, movementName) {
                if(confirm("Tem certeza que realmente quer deletar a movimentação \"" + movementName + "\"? " +
                    "O valor será retornado para a carteira vinculada.")) {
                    await apiRouter.movement.delete(id)
                    this.messageSuccess('Movimentação deletada com sucesso!')
                    await this.getMovementIndexFiltered(this.lastFilter)
                }
            },
            async deleteTransfer(id, movementName) {
                if(confirm("Tem certeza que realmente quer deletar a transferência \"" + movementName + "\"? " +
                    "O valor será retornado para a carteira vinculada.")) {
                    await apiRouter.movement.deleteTransfer(id)
                    this.messageSuccess('Transferência deletada com sucesso!')
                    await this.getMovementIndexFiltered(this.lastFilter)
                }
            },
            async getMovementIndexFiltered(filterId) {
                this.loadingDone = false
                this.movements = await apiRouter.movement.indexFiltered(filterId)
                let sum = numberTools.getSumAmountPerMovementType(this.movements)
                this.totalSpent = sum.totalSpent
                this.totalGain = sum.totalGain
                this.balance = sum.totalGain - sum.totalSpent
                this.loadingDone = true
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
            }
        },
        async mounted() {
            this.filterList = MovementEnum.getFilterList()
            await this.getMovementIndexFiltered(MovementEnum.filter.thisMonth())
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .movement-transfer-icon {
        color: $info-icon-color;
    }
    .movement-spent-icon {
        color: $danger-icon-color;
    }
    .movement-gain-icon {
        color: $success-icon-color;
    }
    .card {
        width: 24rem;
    }
    .balance-card {
        width: 80.5rem;
    }
    .card-text {
        font-size: 1.5rem;
    }

    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .me-2 {
            margin-right: 0 !important;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .balance-card {
            width: 100%;
        }
        .ms-1 {
            margin-left: 0 !important;
            margin-right: 2px !important;
        }
        .delete-button {
            border-radius: 8px !important;
            font-size: 20px !important;
            width: 50px !important;
        }
        .resume-content {
            display: table-row;
            white-space: nowrap;
        }
        .resume-content .row {
            display: table-cell;
        }
        .resume-content h6,
        .resume-content .col-4 {
            font-size: 0.8rem;
            width: 33%;
        }
        .resume-value .col-4 {
            margin-bottom: 0.28rem;
        }
        .resume-value {
            white-space: nowrap;
            overflow: hidden;
        }
    }
</style>