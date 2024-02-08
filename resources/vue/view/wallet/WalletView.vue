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
            <div class="card glass">
                <div class="card-body">
                    <div class="text-center" v-if="wallets.length === 0">
                        <div class="col-12">
                            <hr class="mfp-card-divider">
                        </div>
                        <span>Nenhuma carteira cadastrada ainda!</span>
                        <div class="col-12">
                            <hr class="mfp-card-divider">
                        </div>
                    </div>
                    <div class="row ms-1 me-1" v-else v-for="wallet in wallets" :key="wallet.id">
                        <div class="col-11">
                            <div class="row">
                                <div class="col-12">
                                    <strong>{{ wallet.name }}</strong>
                                </div>
                            </div>
                            <div class="row text-sm">
                                <div class="col-6">
                                    <span>Tipo: {{ walletEnum.getDescription(wallet.type) }}</span>
                                </div>
                                <div class="col-6">
                                    Valor:
                                    <span>{{ stringTools.formatFloatValueToBrString(wallet.amount) }}</span>
                                    <alert-icon v-if="wallet.amount < 0" />
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
                                <ul class="dropdown-menu">
                                    <li>
                                        <router-link
                                            class="dropdown-item"
                                            :to="'/carteiras/' + wallet.id + '/atualizar'"
                                            v-tooltip="'Editar'">
                                            <font-awesome-icon :icon="iconEnum.editIcon()" />
                                            Editar
                                        </router-link>
                                    </li>
                                    <li>
                                        <button class="dropdown-item"
                                                @click="deleteWallet(wallet.id, wallet.name)"
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
                    <div class="row ms-1 me-1">
                        <div class="col-12 text-center">
                            <span>Total: {{ stringTools.formatFloatValueToBrString(sumTotalAmount) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card glass mt-4">
                <div class="row ms-1 me-1">
                    <div class="card-body text-center">
                        <h4 class="card-title">
                            <span>
                                <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                                Resumo
                            </span>
                        </h4>
                        <div class="col-12">
                            <hr class="mfp-card-divider">
                        </div>
                        <div class="resume-content">
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
import apiRouter from '~js/router/apiRouter'
import walletEnum from '~js/enums/walletEnum'
import stringTools from '~js/tools/stringTools'
import numberTools from '~js/tools/numberTools'
import iconEnum from '~js/enums/iconEnum'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import AlertIcon from '~vue-component/AlertIcon.vue'
import messageTools from '~js/tools/messageTools'

export default {
    name: 'WalletView',
    components: {
        AlertIcon,
        MfpMessage,
        MfpTitle,
        Divider,
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
            wallets: [],
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
            this.separeWalletsPerTypes()
        },
        separeWalletsPerTypes() {
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
    @media (max-width: 1000px) {
        .nav {
            flex-direction: column;
        }
        .top-button {
            margin-top: 10px;
            border-radius: 8px !important;
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
        .resume-content .col-2 {
            font-size: 0.8rem;
        }
        .resume-value .col-2 {
            margin-bottom: 0.28rem;
        }
        .resume-value {
            white-space: nowrap;
            overflow: hidden;
            margin-left: 0.5rem;
        }
        .text-sm {
            font-size: 0.6rem;
        }
    }
</style>