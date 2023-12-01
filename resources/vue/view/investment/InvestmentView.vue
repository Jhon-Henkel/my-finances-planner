<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Investimentos"/>
                <mfp-drop-down-button :buttons-array="buttons" />
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
                                            <th scope="col">Valor</th>
                                            <th scope="col">Liquidez</th>
                                            <th scope="col">Rentabilidade</th>
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
                                            <td>{{ investment.amount }}</td>
                                            <td>{{ investment.liquidity }}</td>
                                            <td>{{ investment.profitability }}</td>
                                            <td>
                                                <action-buttons delete-tooltip="Deletar"
                                                                tooltip-edit="Editar"
                                                                :edit-to="'investimentos/cdb/' + investment.id + '/atualizar'"
                                                                @delete-clicked="deleteInvestment(investment.id, investment.description)" />
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
import MfpMessage from '~vue-component/MessageAlert.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import Divider from '~vue-component/DividerComponent.vue'
import IconEnum from '~js/enums/iconEnum'
import apiRouter from '~js/router/apiRouter'
import messageEnum from '~js/enums/messageEnum'
import ActionButtons from '~vue-component/ActionButtons.vue'
import messageTools from '~js/tools/messageTools'
import investmentEnum from '~js/enums/investmentEnum'

export default {
    name: 'InvestmentView',
    computed: {
        investmentEnum() {
            return investmentEnum
        }
    },
    components: {
        ActionButtons,
        Divider,
        MfpDropDownButton,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            messageData: {},
            loadingDone: true,
            buttons: [
                {
                    title: 'Novo CDB',
                    icon: IconEnum.billTrendUp(),
                    redirectTo: '/investimentos/cdb/cadastrar'
                }
            ],
            investments: []
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
        }
    },
    mounted() {
        this.getInvestments()
    }
}
</script>

<style scoped>
@media (max-width: 1000px) {
    .nav {
        flex-direction: column;
    }
}
</style>