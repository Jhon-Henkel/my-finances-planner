<template>
    <mfp-message :message-data="messageData"/>
    <div class="base-container">
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-title :title="title" class="title"/>
            <divider/>
            <form class="was-validated">
                <div class="row justify-content-center">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="investment-description">
                                Descrição
                            </label>
                            <input type="text"
                                   class="form-control"
                                   v-model="investment.description"
                                   id="investment-description"
                                   required
                                   minlength="2">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="investment-type">
                                Tipo
                            </label>
                            <select class="form-select" v-model="investment.type" id="investment-type" required>
                                <option v-for="type in types" :key="type.id" :value="type.id">
                                    {{ type.label }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-if="investment.type === investmentEnum.type.cdbCreditLimit()">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="investment-credit-card">
                                Cartão de crédito
                            </label>
                            <select class="form-select" v-model="investment.creditCardId" id="investment-credit-card" required>
                                <option v-for="creditCard in creditCards" :key="creditCard.id" :value="creditCard.id">
                                    {{ creditCard.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
                <input-money :value="investment.amount" @input-money="investment.amount = $event"/>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="investment-liquidity">
                                Liquidez
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <strong>D+</strong>
                                </span>
                                <input type="number"
                                       class="form-control"
                                       v-model="investment.liquidity"
                                       id="investment-liquidity"
                                       required
                                       minlength="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="investment-profitability">
                                Rentabilidade
                            </label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">
                                    <font-awesome-icon :icon="IconEnum.percent()" />
                                </span>
                                <input type="text"
                                       class="form-control"
                                       v-model="investment.profitability"
                                       id="investment-profitability"
                                       required
                                       minlength="1">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/investimentos/cdb"
                            :button-success-text="title"
                            @btn-clicked="updateOrInsertInvestment"/>
        </div>
    </div>
</template>

<script>
import MfpMessage from '~vue-component/MessageAlert.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import Divider from '~vue-component/DividerComponent.vue'
import BottomButtons from '~vue-component/BottomButtons.vue'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import InvestmentEnum from '~js/enums/investmentEnum'
import apiRouter from '~js/router/apiRouter'
import IconEnum from '~js/enums/iconEnum'
import messageTools from '~js/tools/messageTools'

export default {
    name: 'InvestmentCdbForm',
    computed: {
        investmentEnum() {
            return InvestmentEnum
        },
        IconEnum() {
            return IconEnum
        }
    },
    components: {
        InputMoney,
        BottomButtons,
        Divider,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            messageData: {},
            loadingDone: false,
            title: 'Cadastrar CDB',
            isValid: false,
            investment: {
                profitability: '',
                liquidity: '',
                creditCardId: null
            },
            types: InvestmentEnum.getFilterList(),
            creditCards: []
        }
    },
    methods: {
        async updateOrInsertInvestment() {
            this.validateInvestment()
            if (!this.isValid) {
                return
            }
            if (this.$route.params.id) {
                await this.updateInvestment()
                return
            }
            await this.insertInvestment()
        },
        validateInvestment() {
            let field = null
            if (!this.investment.description) {
                field = 'descrição'
            } else if (!this.investment.type) {
                field = 'tipo'
            } else if (
                !this.investment.creditCardId &&
                this.investment.type === InvestmentEnum.type.cdbCreditLimit()
            ) {
                field = 'cartão de crédito'
            } else if (!this.investment.amount) {
                field = 'valor'
            } else if (!this.investment.liquidity) {
                field = 'liquidez'
            } else if (!this.investment.profitability) {
                field = 'rentabilidade'
            }
            if (field) {
                this.messageData = messageTools.invalidFieldMessage(field)
                this.isValid = false
                return
            }
            this.isValid = true
        },
        async updateInvestment() {
            await apiRouter.investments.update(this.populateInvestment(), this.investment.id).then((response) => {
                this.messageData = messageTools.successMessage('Investimento atualizado com sucesso')
            }).catch((error) => {
                this.messageData = messageTools.errorMessage(error)
            })
        },
        async insertInvestment() {
            await apiRouter.investments.insert(this.populateInvestment()).then((response) => {
                this.messageData = messageTools.successMessage('Investimento cadastrado com sucesso')
            }).catch((error) => {
                this.messageData = messageTools.errorMessage(error)
            })
        },
        populateInvestment() {
            return {
                description: this.investment.description,
                type: this.investment.type,
                creditCardId: this.investment.creditCardId,
                amount: this.investment.amount,
                liquidity: this.investment.liquidity,
                profitability: this.investment.profitability
            }
        }
    },
    async mounted() {
        if (this.$route.params.id) {
            this.title = 'Atualizar CDB'
            this.investment = await apiRouter.investments.show(this.$route.params.id)
        }
        this.creditCards = await apiRouter.cards.index()
        this.loadingDone = true
    }
}
</script>

<style>
    @media (max-width: 1000px) {
        .title {
            margin: auto auto auto 75px !important;
        }
    }
</style>