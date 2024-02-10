<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false" />
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title class="title" title="Movimentações"/>
                <mfp-search-bar @search-for="filterResultsSearch($event)" placeholder="Buscar por descrição ou carteira"/>
                <filter-top-right @filter-quest="getMovementIndexFiltered($event)"/>
                <mfp-drop-down-button :buttonsArray="buttons"/>
            </div>
            <divider/>
            <div class="card glass">
                <div class="card-body">
                    <div class="text-center" v-if="movements.length === 0">
                        <div class="col-12">
                            <hr class="mfp-card-divider">
                        </div>
                        <span>Nenhuma movimentação cadastrada ainda!</span>
                        <div class="col-12">
                            <hr class="mfp-card-divider">
                        </div>
                    </div>
                    <div class="row ms-1 me-1" v-else v-for="movement in movements" :key="movement.id">
                        <div class="col-1 d-flex justify-content-center align-items-center">
                            <font-awesome-icon :icon="iconTools.getIconForMovementType(movement.type)"
                                               :class="iconTools.getCssForMovementType(movement.type)"/>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-12">
                                    <strong>{{ movement.description }}</strong>
                                </div>
                            </div>
                            <div class="row text-sm">
                                <div class="col-7">
                                    <span>Carteira: </span>
                                    <span>{{ movement.walletName }}</span>
                                </div>
                                <div class="col-5">
                                    <span>Valor: </span>
                                    <span>{{ StringTools.formatFloatValueToBrString(movement.amount) }}</span>
                                </div>
                            </div>
                            <div class="row text-sm">
                                <div class="col-12">
                                    <span>Data: </span>
                                    <span>{{ calendarTools.convertDateDbToBr(movement.createdAt) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-center">
                            <div class="dropdown-center">
                                <button class="btn btn-outline-success"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <font-awesome-icon :icon="iconEnum.ellipsisVertical()"/>
                                </button>
                                <ul class="dropdown-menu" v-if="movement.type !== MovementEnum.type.transfer()">
                                    <li>
                                        <router-link
                                            class="dropdown-item"
                                            :to="'/movimentacoes/' + movement.id + '/atualizar'"
                                            v-tooltip="'Editar'">
                                            <font-awesome-icon :icon="iconEnum.editIcon()" />
                                            Editar
                                        </router-link>
                                    </li>
                                    <li>
                                        <button class="dropdown-item"
                                                @click="deleteMovement(movement.id, movement.description)"
                                                v-tooltip="'Apagar'">
                                            <font-awesome-icon :icon="iconEnum.trashIcon()" />
                                            Apagar
                                        </button>
                                    </li>
                                </ul>
                                <ul class="dropdown-menu" v-else>
                                    <li>
                                        <button class="dropdown-item"
                                                @click="deleteTransfer(movement.id, movement.description)"
                                                v-tooltip="'Apagar'">
                                            <font-awesome-icon :icon="iconEnum.trashIcon()" />
                                            Apagar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="mfp-card-divider">
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
                        <hr class="mfp-card-divider">
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
import iconEnum from '~js/enums/iconEnum'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import MovementEnum from '~js/enums/movementEnum'
import apiRouter from '~js/router/apiRouter'
import calendarTools from '~js/tools/calendarTools'
import numberTools from '~js/tools/numberTools'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import StringTools from '~js/tools/stringTools'
import AlertIcon from '~vue-component/AlertIcon.vue'
import FilterTopRight from '~vue-component/filters/filterTopRight.vue'
import messageTools from '~js/tools/messageTools'
import MfpSearchBar from '~vue-component/search/SearchBar.vue'
import iconTools from '~js/tools/iconTools'

export default {
    name: 'MovementView',
    computed: {
        iconTools() {
            return iconTools
        },
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
        MfpSearchBar,
        FilterTopRight,
        AlertIcon,
        MfpMessage,
        MfpTitle,
        Divider,
        LoadingComponent,
        MfpDropDownButton
    },
    data() {
        return {
            loadingDone: false,
            movements: [],
            originalMovements: [],
            filterList: {},
            totalSpent: 0,
            totalGain: 0,
            balance: 0,
            lastFilter: null,
            messageData: {},
            buttons: [
                {
                    title: 'Novo Gasto/Ganho',
                    icon: iconEnum.movement(),
                    redirectTo: '/movimentacoes/cadastrar'
                },
                {
                    title: 'Nova Transferência',
                    icon: iconEnum.buildingColumns(),
                    redirectTo: '/movimentacoes/transferir'
                }
            ]
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
            this.originalMovements = this.movements
            this.populateMoneyValues()
            this.loadingDone = true
        },
        populateMoneyValues() {
            const sum = numberTools.getSumAmountPerMovementType(this.movements)
            this.totalSpent = sum.totalSpent
            this.totalGain = sum.totalGain
            this.balance = sum.totalGain - sum.totalSpent
        },
        filterResultsSearch(search) {
            let movements = this.originalMovements
            movements = movements.filter(
                movement =>
                    movement.walletName.toLowerCase().includes(search.toLowerCase()) ||
                    movement.description.toLowerCase().includes(search.toLowerCase())
            )
            this.movements = movements
            this.populateMoneyValues()
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
    .movement-investment-icon {
        color: $alert-icon-color;
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
    .title {
        margin: auto 0 auto 0;
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
            width: 100%;
            white-space: nowrap;
            display: flex;
            justify-content: center;
        }
        .resume-content .row {
            display: table-cell;
        }
        .resume-content h6,
        .resume-content .col-4 {
            font-size: 0.7rem;
            width: 33%;
        }
        .resume-value .col-4 {
            margin-bottom: 0.28rem;
            margin-left: 0.5rem;
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
        .title {
            margin: auto auto 20px;
        }
    }
</style>