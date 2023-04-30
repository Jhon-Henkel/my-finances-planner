<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Movimentações'"/>
                <font-awesome-icon :icon="iconEnum.filterMoney()" class="me-2 mt-1 filter"/>
                <div class="form-group me-3">
                    <select class="form-select form-select-sm" @change="getMovementsByFilter($event)">
                        <option v-for="filter in filterList" :key="filter.id" :value="filter.id">
                            {{ filter.label }}
                        </option>
                    </select>
                </div>
                <router-link class="btn btn-success rounded-5" to="/movimentacoes/cadastrar">
                    <font-awesome-icon :icon="iconEnum.movement()" class="me-2"/>
                    Nova Movimentação
                </router-link>
            </div>
            <divider/>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center"></th>
                        <th class="text-center">ID</th>
                        <th class="text-center" scope="col">Descrição</th>
                        <th class="text-center" scope="col">Tipo</th>
                        <th class="text-center" scope="col">Carteira</th>
                        <th class="text-center" scope="col">Valor</th>
                        <th class="text-center" scope="col">Data</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="movement in movements" :key="movement.id">
                        <td class="text-center">
                            <font-awesome-icon v-if="movement.type === movementEnum.type.transfer()" :icon="iconEnum.circleArrowRight()" class="movement-transfer-icon"/>
                            <font-awesome-icon v-else-if="movement.type === movementEnum.type.spent()" :icon="iconEnum.circleArrowDown()" class="movement-spent-icon"/>
                            <font-awesome-icon v-else-if="movement.type === movementEnum.type.gain()" :icon="iconEnum.circleArrowUp()" class="movement-gain-icon"/>
                        </td>
                        <td class="text-center">{{ movement.id }}</td>
                        <td class="text-center">{{ movement.description }}</td>
                        <td class="text-center">{{ movementEnum.getLabelForType(movement.type) }}</td>
                        <td class="text-center">{{ movement.walletName }}</td>
                        <td class="text-center">{{ stringTools.formatFloatValueToBrString(movement.amount) }}</td>
                        <td class="text-center">{{ calendarTools.convertDateDbToBr(movement.createdAt) }}</td>
                        <td class="text-center">
                            <action-buttons
                                :delete-tooltip="'Deletar Movimentação'"
                                :tooltip-edit="'Editar Movimentação'"
                                :edit-to="'/movimentacoes/' + movement.id + '/atualizar'"
                                @delete-clicked="deleteMovement(movement.id, movement.description)" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row ms-1">
                <div class="card glass success balance-card">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.movement()" class="me-2"/>
                            Resumo
                        </h4>
                        <hr>
                        <div class="card-text">
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
                            <div class="row">
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(totalGain) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalGain < 0"/>
                                </div>
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(totalSpent) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="totalSpent < 0"/>
                                </div>
                                <div class="col-4">
                                    {{ StringTools.formatFloatValueToBrString(balance) }}
                                    <font-awesome-icon :icon="alertIcon" class="icon-alert" v-if="balance < 0"/>
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
            MfpMessage,
            MfpTitle,
            Divider,
            ActionButtons,
            LoadingComponent,
        },
        data() {
            return {
                alertIcon: iconEnum.triangleExclamation(),
                loadingDone: false,
                movements: {},
                filterList: {},
                totalSpent: 0,
                totalGain: 0,
                balance: 0,
                lastFilter: null
            }
        },
        methods: {
            async deleteMovement(id, movement) {
                if(confirm("Tem certeza que realmente quer deletar a movimentação \"" + movement + "\"? " +
                    "O valor será retornado para a carteira vinculada.")) {
                    await apiRouter.movement.delete(id)
                    this.messageSuccess('Movimentação deletada com sucesso!')
                    await this.getMovementIndexFiltered(this.lastFilter)
                }
            },
            async getMovementsByFilter(event) {
                let filterId = event.target.value
                this.lastFilter = filterId
                await this.getMovementIndexFiltered(filterId)
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

<style scoped>
    .filter {
        font-size: 22px;
        color: #12c4a1;
    }
    .movement-transfer-icon {
        color: #4a54ea;
    }
    .movement-spent-icon {
        color: #eb4e2c;
    }
    .movement-gain-icon {
        color: #12c4a1;
    }
    .icon-alert {
        color: #e0c857;
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
</style>