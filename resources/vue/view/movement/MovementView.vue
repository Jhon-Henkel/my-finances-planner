<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <message :message="message" :type="messageType" v-show="message"/>
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">Movimentações</h3>
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
            <hr class="mb-4">
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center"></th>
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
            <hr class="mt-4">
            <div class="text-end">
                <h3>
                    <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="movement-gain-icon"/>
                    Total Ganho: {{ stringTools.formatFloatValueToBrString(totalGain) }}
                </h3>
                <h3>
                    <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="movement-spent-icon"/>
                    Total Gasto: {{ stringTools.formatFloatValueToBrString(totalSpent) }}
                </h3>
                <div>
                    <h3>
                        <font-awesome-icon :icon="iconEnum.triangleExclamation()" class="me-2 icon-alert" v-if="balance < 0"/>
                        Balanço: {{ stringTools.formatFloatValueToBrString(balance) }}
                    </h3>
                    <span class="badge text-bg-danger" v-if="balance < 0">
                        <font-awesome-icon :icon="iconEnum.triangleExclamation()" class="me-2"/>
                        Cuidado, você está com balanço negativo!
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Message from "../../components/MessageComponent.vue";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import CalendarTools from "../../../js/tools/calendarTools";
    import ActionButtons from "../../components/ActionButtons.vue";
    import MovementEnum from "../../../js/enums/movementEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import stringTools from "../../../js/tools/stringTools";
    import calendarTools from "../../../js/tools/calendarTools";
    import movementEnum from "../../../js/enums/movementEnum";
    import numberTools from "../../../js/tools/numberTools";
    import messageEnum from "../../../js/enums/messageEnum";

    export default {
        name: "MovementView",
        computed: {
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
            ActionButtons,
            LoadingComponent,
            Message
        },
        data() {
            return {
                loadingDone: false,
                message: null,
                messageType: null,
                movements: {},
                messageTimeOut: CalendarTools.fiveSecondsTimeInMs(),
                filterList: {},
                totalSpent: 0,
                totalGain: 0,
                balance: 0,
                lastFilter: null
            }
        },
        methods: {
            async deleteMovement(id, movement) {
                if(confirm("Tem certeza que realmente quer deletar a movimentação \"" + movement + "\"?")) {
                    await apiRouter.movement.delete(id)
                    this.message = "Movimentação deletada com sucesso!"
                    this.messageType = messageEnum.messageTypeSuccess()
                    this.resetMessage()
                    this.movements = await apiRouter.movement.indexFiltered(this.lastFilter)
                    this.updateMovementDetails()
                }
            },
            async getMovementsByFilter(event) {
                let filterId = event.target.value
                this.lastFilter = filterId
                this.movements = await apiRouter.movement.indexFiltered(filterId)
                this.updateMovementDetails()
            },
            updateMovementDetails() {
                let sum = numberTools.getSumAmountPerMovementType(this.movements)
                this.totalSpent = sum.totalSpent
                this.totalGain = sum.totalGain
                this.balance = sum.totalGain - sum.totalSpent
            },
            resetMessage() {
                setTimeout(() =>
                    [this.message = null, this.messageType = null],
                    this.messageTimeOut
                )
            },
        },
        async mounted() {
            this.filterList = MovementEnum.getFilterList()
            this.movements = await apiRouter.movement.indexFiltered(MovementEnum.filter.thisMonth())
            this.updateMovementDetails()
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
        color: #fa2d2d;
    }
    .movement-gain-icon {
        color: #12c4a1;
    }
    .icon-alert {
        color: #fdd200;
    }
</style>