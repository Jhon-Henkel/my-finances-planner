<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Carteiras"/>
                <router-link class="btn btn-success rounded-2 top-button" to="/carteiras/cadastrar">
                    <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                    Nova Carteira
                </router-link>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th scope="col">Carteira</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Valor Atual</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center table-body-hover">
                                    <tr v-show="wallets.length === 0">
                                        <td colspan="4">Nenhuma carteira cadastrada ainda!</td>
                                    </tr>
                                    <tr v-for="wallet in wallets" :key="wallet.id" class="text-center">
                                        <td>{{ wallet.name }}</td>
                                        <td>{{ walletEnum.getDescription(wallet.type) }}</td>
                                        <td>
                                            {{ stringTools.formatFloatValueToBrString(wallet.amount) }}
                                            <alert-icon v-if="wallet.amount < 0" />
                                        </td>
                                        <td>
                                            <action-buttons
                                                :delete-tooltip="'Deletar Carteira'"
                                                :tooltip-edit="'Editar Carteira'"
                                                :edit-to="'/carteiras/' + wallet.id + '/atualizar'"
                                                @delete-clicked="deleteWallet(wallet.id, wallet.name)" />
                                        </td>
                                    </tr>
                                    <tr class="border-table">
                                        <td colspan="2">Total</td>
                                        <td colspan="2">{{ stringTools.formatFloatValueToBrString(sumTotalAmount) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ms-1 mt-4">
                <div class="card glass success balance-card card-resume balance-card-resume">
                    <div class="card-body text-center resume-card">
                        <h4 class="card-title">
                            <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                            Resumo
                        </h4>
                        <hr>
                        <div class="card-text resume-content card-text-resume">
                            <div class="row">
                                <div class="col-2">
                                    <h6>Dinheiro</h6>
                                </div>
                                <div class="col-2">
                                    <h6>Banco</h6>
                                </div>
                                <div class="col-2">
                                    <h6>Vale Alimentação</h6>
                                </div>
                                <div class="col-2">
                                    <h6>Vale Transporte</h6>
                                </div>
                                <div class="col-2">
                                    <h6>Vale Saúde</h6>
                                </div>
                                <div class="col-2">
                                    <h6>Outros</h6>
                                </div>
                            </div>
                            <div class="row resume-value">
                                <div class="col-2">
                                    {{ stringTools.formatFloatValueToBrString(walletsPerType.money) }}
                                </div>
                                <div class="col-2">
                                    {{ stringTools.formatFloatValueToBrString(walletsPerType.bank) }}
                                </div>
                                <div class="col-2">
                                    {{ stringTools.formatFloatValueToBrString(walletsPerType.mealTicket) }}
                                </div>
                                <div class="col-2">
                                    {{ stringTools.formatFloatValueToBrString(walletsPerType.transportTicket) }}
                                </div>
                                <div class="col-2">
                                    {{ stringTools.formatFloatValueToBrString(walletsPerType.healthTicketType) }}
                                </div>
                                <div class="col-2">
                                    {{ stringTools.formatFloatValueToBrString(walletsPerType.others) }}
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
import apiRouter from '../../../js/router/apiRouter'
import walletEnum from '../../../js/enums/walletEnum'
import stringTools from '../../../js/tools/stringTools'
import numberTools from '../../../js/tools/numberTools'
import iconEnum from '../../../js/enums/iconEnum'
import LoadingComponent from '../../components/LoadingComponent.vue'
import ActionButtons from '../../components/ActionButtons.vue'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import MfpMessage from '../../components/MessageAlert.vue'
import AlertIcon from '../../components/AlertIcon.vue'
import messageTools from '../../../js/tools/messageTools'

export default {
    name: 'WalletView',
    components: {
        AlertIcon,
        MfpMessage,
        MfpTitle,
        Divider,
        ActionButtons,
        LoadingComponent
    },
    computed: {
        iconEnum() {
            return iconEnum
        },
        walletEnum() {
            return walletEnum
        },
        stringTools() {
            return stringTools
        }
    },
    data() {
        return {
            wallets: {},
            wallet: {
                updatedAt: ''
            },
            sumTotalAmount: 0,
            loadingDone: false,
            walletsPerType: {
                money: 0,
                bank: 0,
                mealTicket: 0,
                transportTicket: 0,
                healthTicketType: 0,
                others: 0
            },
            messageData: {}
        }
    },
    methods: {
        async getWallets() {
            this.loadingDone = false
            this.wallets = await apiRouter.wallet.index()
            this.sumTotalAmount = numberTools.getSumTotalAmount(this.wallets)
            this.loadingDone = true
            this.separeWallets()
        },
        separeWallets() {
            this.wallets.forEach(wallet => {
                if (wallet.type === walletEnum.type.bankType) {
                    this.walletsPerType.bank += wallet.amount
                } else if (wallet.type === walletEnum.type.moneyType) {
                    this.walletsPerType.money += wallet.amount
                } else if (wallet.type === walletEnum.type.otherType) {
                    this.walletsPerType.others += wallet.amount
                } else if (wallet.type === walletEnum.type.mealTicketType) {
                    this.walletsPerType.mealTicket += wallet.amount
                } else if (wallet.type === walletEnum.type.transportTicketType) {
                    this.walletsPerType.transportTicket += wallet.amount
                } else if (wallet.type === walletEnum.type.healthTicketType) {
                    this.walletsPerType.healthTicketType += wallet.amount
                }
            })
        },
        async deleteWallet(walletId, walletName) {
            if (confirm('Tem certeza que realmente quer deletar a carteira ' + walletName + '?')) {
                await apiRouter.wallet.delete(walletId).then((response) => {
                    this.messageData = messageTools.successMessage('Carteira deletada com sucesso!')
                    this.getWallets()
                }).catch((response) => {
                    this.messageData = messageTools.errorMessage(response.response.data.message)
                })
            }
        }
    },
    mounted() {
        this.getWallets()
    }
}
</script>

<style lang="scss" scoped>
    @import "../../../sass/_variables.scss";
    .icon-alert {
         color: $alert-icon-color;
         font-size: 15px;
         top: 50%;
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
    .border-table {
        border-top: 2px solid $table-line-divider-color;
    }
    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
        }
        .balance-card-resume {
            width: 97%;
        }
        .resume-content {
            display: table-row;
            width: 100%;
            white-space: nowrap;
        }
        .resume-content .row {
            display: table-cell;
        }
        .resume-content h6,
        .resume-content .col-2 {
            font-size: 0.8rem;
        }
        .resume-value .col-2 {
            margin-bottom: 0.28rem;
        }
        .resume-value {
            white-space: nowrap;
            overflow: hidden;
        }
    }
</style>