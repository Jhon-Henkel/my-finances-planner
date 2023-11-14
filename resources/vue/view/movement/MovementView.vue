<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Movimentações"/>
                <filter-top-right @filter-quest="getMovementIndexFiltered($event)"/>
                <mfp-drop-down-button />
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr>
                                        <th></th>
                                        <th scope="col">Descrição</th>
                                        <th scope="col">Carteira</th>
                                        <th scope="col">Valor</th>
                                        <th scope="col">Data</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center table-body-hover">
                                    <tr v-show="movements.length === 0">
                                        <td colspan="8">Nenhuma movimentação cadastrada ainda!</td>
                                    </tr>
                                    <tr v-for="movement in movements" :key="movement.id">
                                        <td>
                                            <font-awesome-icon v-if="movement.type === MovementEnum.type.transfer()"
                                                            :icon="iconEnum.circleArrowRight()"
                                                            class="movement-transfer-icon"/>
                                            <font-awesome-icon v-else-if="movement.type === MovementEnum.type.spent()"
                                                            :icon="iconEnum.circleArrowDown()"
                                                            class="movement-spent-icon"/>
                                            <font-awesome-icon v-else-if="movement.type === MovementEnum.type.gain()"
                                                            :icon="iconEnum.circleArrowUp()"
                                                            class="movement-gain-icon"/>
                                        </td>
                                        <td class="text-start">{{ movement.description }}</td>
                                        <td class="text-start">{{ movement.walletName }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(movement.amount) }}</td>
                                        <td>{{ calendarTools.convertDateDbToBr(movement.createdAt) }}</td>
                                        <td>
                                            <action-buttons
                                                v-if="movement.type !== MovementEnum.type.transfer()"
                                                :delete-tooltip="'Deletar Movimentação'"
                                                :tooltip-edit="'Editar Movimentação'"
                                                :edit-to="'/movimentacoes/' + movement.id + '/atualizar'"
                                                @delete-clicked="deleteMovement(movement.id, movement.description)"/>
                                            <div class="text-center action-buttons" v-if="movement.type === MovementEnum.type.transfer()">
                                                <button class="btn btn-sm btn-danger rounded-2 text-center action-buttons delete-button"
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
                    </div>
                </div>
            </div>
            <div class="row ms-1 mt-4">
                <div class="card glass success balance-card card-resume balance-card-resume">
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
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import iconEnum from '~js/enums/iconEnum.js'
import ActionButtons from '~vue-component/ActionButtons.vue'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import MovementEnum from '~js/enums/movementEnum.js'
import apiRouter from '~js/router/apiRouter.js'
import calendarTools from '~js/tools/calendarTools.js'
import numberTools from '~js/tools/numberTools.js'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import StringTools from '~js/tools/stringTools.js'
import AlertIcon from '~vue-component/AlertIcon.vue'
import FilterTopRight from '~vue-component/filters/filterTopRight.vue'
import messageTools from '~js/tools/messageTools.js'

export default {
    name: 'MovementView',
    computed: {
        StringTools() {
            return StringTools
        },
        MovementEnum() {
            return MovementEnum
        },
        calendarTools() {
            return calendarTools
        },
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        FilterTopRight,
        AlertIcon,
        MfpMessage,
        MfpTitle,
        Divider,
        ActionButtons,
        LoadingComponent,
        MfpDropDownButton
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
            messageData: {}
        }
    },
    methods: {
        async deleteMovement(id, movementName) {
            if (confirm('Tem certeza que realmente quer deletar a movimentação "' + movementName + '"? ' +
                    'O valor será retornado para a carteira vinculada.')) {
                await apiRouter.movement.delete(id)
                this.messageData = messageTools.successMessage('Movimentação deletada com sucesso!')
                await this.getMovementIndexFiltered(this.lastFilter)
            }
        },
        async deleteTransfer(id, movementName) {
            if (confirm('Tem certeza que realmente quer deletar a transferência "' + movementName + '"? ' +
                    'O valor será retornado para a carteira vinculada.')) {
                await apiRouter.movement.deleteTransfer(id)
                this.messageData = messageTools.successMessage('Transferência deletada com sucesso!')
                await this.getMovementIndexFiltered(this.lastFilter)
            }
        },
        async getMovementIndexFiltered(quest) {
            this.loadingDone = false
            this.movements = await apiRouter.movement.indexFiltered(quest)
            const sum = numberTools.getSumAmountPerMovementType(this.movements)
            this.totalSpent = sum.totalSpent
            this.totalGain = sum.totalGain
            this.balance = sum.totalGain - sum.totalSpent
            this.loadingDone = true
        }
    },
    async mounted() {
        this.filterList = MovementEnum.getFilterList()
        await this.getMovementIndexFiltered()
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
    .card-resume {
        width: 24rem;
    }
    .balance-card-resume {
        width: 80.5rem;
    }
    .card-text-resume {
        font-size: 1.5rem;
    }

    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .me-2 {
            margin-right: 0 !important;
        }
        .me-3 {
            margin-right: 0 !important;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .balance-card-resume {
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
        .dropdown-menu {
            width: 98%;
            padding: 10px;
            margin-left: 1%;
            margin-right: 1%;
        }
    }
</style>