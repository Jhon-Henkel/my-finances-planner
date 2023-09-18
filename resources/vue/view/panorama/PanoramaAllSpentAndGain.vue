<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone < 2"/>
        <div v-show="loadingDone >= 2">
            <div class="nav justify-content-end">
                <mfp-title title="Gerenciar despesas e ganhos" class="title"/>
                <back-button to="/panorama" class="top-button"/>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <td colspan="11" class="border-table">
                                            <font-awesome-icon :icon="iconEnum.circleArrowDown()" class="spent-icon me-2"/>
                                            Todas as Despesas (Exceto Cartões)
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <td>Id</td>
                                        <td>Nome Carteira</td>
                                        <td>Descrição</td>
                                        <td>Valor</td>
                                        <td>Parcelas</td>
                                        <td>Primeiro Vencimento</td>
                                        <td>Ações</td>
                                    </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                    <tr v-for="spent in spending" :key="spending.id" class="text-center">
                                        <td>{{ spent.id }}</td>
                                        <td>{{ spent.walletName }}</td>
                                        <td>{{ spent.description }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(spent.amount) }}</td>
                                        <td>{{ spent.installments === 0 ? 'Fixo' : spent.installments }}</td>
                                        <td>{{ calendarTools.convertDateDbToBr(spent.forecast) }}</td>
                                        <td>
                                            <action-buttons
                                                :delete-tooltip="'Deletar Despesa'"
                                                :tooltip-edit="'Editar Despesa'"
                                                :edit-to="'/panorama/' + spent.id + '/atualizar-despesa?referer=' + referer"
                                                @delete-clicked="deleteSpent(spent.id, spent.description)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card glass success balance-card mt-4">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <td colspan="11" class="border-table">
                                            <font-awesome-icon :icon="iconEnum.circleArrowUp()" class="gain-icon me-2"/>
                                            Todos os Ganhos
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <td>Id</td>
                                        <td>Nome Carteira</td>
                                        <td>Descrição</td>
                                        <td>Valor</td>
                                        <td>Parcelas</td>
                                        <td>Primeiro Vencimento</td>
                                        <td>Ações</td>
                                    </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                    <tr v-for="gain in gains" :key="gain.id" class="text-center">
                                        <td>{{ gain.id }}</td>
                                        <td>{{ gain.walletName }}</td>
                                        <td>{{ gain.description }}</td>
                                        <td>{{ stringTools.formatFloatValueToBrString(gain.amount) }}</td>
                                        <td>{{ gain.installments === 0 ? 'Fixo' : gain.installments }}</td>
                                        <td>{{ calendarTools.convertDateDbToBr(gain.forecast) }}</td>
                                        <td>
                                            <action-buttons
                                                :delete-tooltip="'Deletar Ganho'"
                                                :tooltip-edit="'Editar Ganho'"
                                                :edit-to="'/ganhos-futuros/' + gain.id + '/atualizar?referer=' + referer"
                                                @delete-clicked="deleteGain(gain.id, gain.description)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <divider/>
        </div>
    </div>
</template>

<script>
import MfpMessage from '../../components/MessageAlert.vue'
import LoadingComponent from '../../components/LoadingComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import Divider from '../../components/DividerComponent.vue'
import iconEnum from '../../../js/enums/iconEnum'
import ApiRouter from '../../../js/router/apiRouter'
import MessageEnum from '../../../js/enums/messageEnum'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import stringTools from '../../../js/tools/stringTools'
import ActionButtons from '../../components/ActionButtons.vue'
import calendarTools from '../../../js/tools/calendarTools'
import BackButton from '../../components/buttons/BackButton.vue'

export default {
    name: 'PanoramaAllSpentAndGain',
    computed: {
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
        BackButton,
        ActionButtons,
        FontAwesomeIcon,
        Divider,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            loadingDone: 0,
            gains: {},
            spending: {},
            referer: 'panorama/todas-despesas-e-ganhos'
        }
    },
    methods: {
        async getAllSpending() {
            await ApiRouter.futureSpent.index().then(response => {
                this.spending = response
            }).catch(error => {
                this.messageError(error.response.data.message)
            })
            this.loadingDone = this.loadingDone + 1
        },
        async getAllGains() {
            await ApiRouter.futureGain.index().then(response => {
                this.gains = response
            }).catch(error => {
                this.messageError(error.response.data.message)
            })
            this.loadingDone = this.loadingDone + 1
        },
        async deleteSpent(id, spentName) {
            if (confirm('Tem certeza que realmente quer deletar a despesa ' + spentName + '?')) {
                await ApiRouter.futureSpent.delete(id).then(response => {
                    this.messageSuccess('Despesa deletada com sucesso!')
                    this.getAllSpending()
                }).catch(() => {
                    this.messageError('Não foi possível deletar a despesa!')
                })
            }
        },
        async deleteGain(id, gainName) {
            if (confirm('Tem certeza que realmente quer deletar o ganho ' + gainName + '?')) {
                await ApiRouter.futureGain.delete(id).then(response => {
                    this.messageSuccess('Ganho deletado com sucesso!')
                    this.getAllGains()
                }).catch(() => {
                    this.messageError('Não foi possível deletar o ganho!')
                })
            }
        },
        messageError(message) {
            this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
        },
        messageSuccess(message) {
            this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
        },
        showMessage(type, message, header) {
            this.$refs.message.showAlert(type, message, header)
        }
    },
    mounted() {
        this.getAllSpending()
        this.getAllGains()
    }
}
</script>

<style scoped lang="scss">
    @import "../../../sass/variables";

    .gain-icon {
        color: $success-icon-color;
    }
    .spent-icon {
        color: $danger-icon-color;
    }
    .border-table {
        border-bottom: 2px solid $table-line-divider-color;
    }
    @media (max-width: 1000px) {
        .title {
            margin: auto auto auto 75px !important;
        }
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
    }
</style>