<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav nav-item mt-2 justify-content-end">
                <mfp-title title="Gerenciamento CDB"/>
                <back-button to="/investimentos" class="me-2"/>
                <router-link-button title="Novo" :icon="iconEnum.billTrendUp()" redirect-to="/investimentos/cdb/cadastrar"/>
            </div>
            <divider/>
            <div class="card glass success balance-card">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">Investimento</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Valor investido</th>
                                        <th scope="col">Liquidez</th>
                                        <th scope="col">Rentabilidade (% do CDI)</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center table-body-hover">
                                    <tr v-show="investments.length === 0">
                                        <td colspan="11">Nenhum investimento cadastrado ainda!</td>
                                    </tr>
                                    <tr v-for="investment in investments" :key="investment.id">
                                        <td>{{ investment.description }}</td>
                                        <td>{{ investmentEnum.getLabel(investment.type) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(investment.amount) }}</td>
                                        <td>D+{{ investment.liquidity }}</td>
                                        <td>{{ investment.profitability }} %</td>
                                        <td>
                                            <action-buttons delete-tooltip="Deletar"
                                                            tooltip-edit="Editar"
                                                            :edit-to="'investimentos/cdb/' + investment.id + '/atualizar'"
                                                            @delete-clicked="deleteInvestment(investment.id, investment.description)"
                                                            :checkButton="true"
                                                            checkTooltip="Resgatar / Aportar Investimento"
                                                            @check-clicked="manageApportRescueInvestment(investment)"/>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <pay-receive :show-pay-receive="showRescueOrApportInvestment"
                         :value="0"
                         :check-tooltip="'Aporte/Resgatar'"
                         :wallet-id="0"
                         @hide-pay-receive="showRescueOrApportInvestment = false"
                         partialLabel="Resgatar"
                         @pay="rescueApportInvestment($event)" />
            <divider/>
        </div>
    </div>
</template>

<script>
import MfpMessage from '~vue-component/MessageAlert.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import Divider from '~vue-component/DividerComponent.vue'
import IconEnum from '~js/enums/iconEnum'
import apiRouter from '~js/router/apiRouter'
import messageEnum from '~js/enums/messageEnum'
import ActionButtons from '~vue-component/ActionButtons.vue'
import messageTools from '~js/tools/messageTools'
import investmentEnum from '~js/enums/investmentEnum'
import StringTools from '~js/tools/stringTools'
import BackButton from '~vue-component/buttons/BackButton.vue'
import RouterLinkButton from '~vue-component/RouterLinkButtonComponent.vue'
import PayReceive from '~vue-component/PayReceiveComponent.vue'

export default {
    name: 'InvestmentCdbView',
    computed: {
        iconEnum() {
            return IconEnum
        },
        StringTools() {
            return StringTools
        },
        investmentEnum() {
            return investmentEnum
        }
    },
    components: {
        PayReceive,
        RouterLinkButton,
        BackButton,
        ActionButtons,
        Divider,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            messageData: {},
            loadingDone: true,
            investments: [],
            investmentToApportOrRescue: {},
            showRescueOrApportInvestment: false
        }
    },
    methods: {
        async getInvestments() {
            this.loadingDone = false
            await apiRouter.investments.index().then(response => {
                this.investments = response
                this.loadingDone = true
            }).catch(error => {
                this.messageData = messageEnum.alertTypeError(error.response.data.message)
            })
        },
        async deleteInvestment(id, description) {
            if (confirm('Tem certeza que realmente quer deletar o investimento ' + description + '?')) {
                await apiRouter.investments.delete(id).then(() => {
                    this.messageData = messageTools.successMessage('Despesa deletada com sucesso!')
                    this.getInvestments()
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível deletar a despesa!')
                })
            }
        },
        async rescueApportInvestment(data) {
            console.log(data)
            console.log('Desenvolver endpoint para resgatar ou aportar investimento')
            // mandar objeto para endpoint
            // recarregar dados
        },
        manageApportRescueInvestment(investment) {
            this.showRescueOrApportInvestment = !this.showRescueOrApportInvestment
            this.investmentToApportOrRescue = investment
        }
    },
    mounted() {
        this.getInvestments()
    }
}
</script>

<style scoped>
@media (max-width: 1000px) {
    .me-2 {
        margin-right: 0 !important;
    }
}
</style>