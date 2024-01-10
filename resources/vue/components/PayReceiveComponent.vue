<template>
    <mfp-message :message-data="messageData"/>
    <div class="row mt-4 was-validated pay-receive" v-show="showPayReceive">
        <div class="col-4 money">
            <input-money :value="value"
                         @input-money="value = $event"
                         :show-title="false"
                         :custom-class-form="''"
                         :custom-class-row="''"
                         :custom-class-col="'col-12'"/>
        </div>
        <div class="col-5 form-group">
            <select class="form-select" v-model="internalWalletId" required>
                <option value="0" disabled selected>Selecione uma carteira</option>
                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                    {{ wallet.name }}
                </option>
            </select>
        </div>
        <div class="col-2 mt-2 switch">
            <div class="form-check form-switch">
                <label class="form-check-label" for="partial">
                    {{ partialLabel }}
                </label>
                <input class="form-check-input" v-model="partial" type="checkbox" role="switch" id="partial">
            </div>
        </div>
        <div class="col-1 button-group" style="margin-top: -25px">
            <button class="btn btn-success rounded-2 me-2"
                    @click="pay"
                    v-tooltip="checkTooltip"
                    disabled
                    v-show="showAlertWalletDontHaveFound">
                <font-awesome-icon :icon="iconEnum.check()"/>
            </button>
            <button class="btn btn-success rounded-2 me-2"
                    @click="pay"
                    v-tooltip="checkTooltip"
                    v-if="! showAlertWalletDontHaveFound && validateWalletValue">
                <font-awesome-icon :icon="iconEnum.check()"/>
            </button>
            <button class="btn btn-danger rounded-2" @click="hidePay" v-tooltip="'Cancelar'">
                <font-awesome-icon :icon="iconEnum.xMark()"/>
            </button>
        </div>
        <div class="mt-4" v-show="showAlertWalletDontHaveFound && validateWalletValue">
            <mfp-alert-message message-type="alert-danger" :message-text="getMessageMissingWalletValue()" />
        </div>
    </div>
</template>

<script>
import InputMoney from './inputMoneyComponent.vue'
import iconEnum from '~js/enums/iconEnum'
import ApiRouter from '~js/router/apiRouter'
import MfpMessage from './MessageAlert.vue'
import messageTools from '~js/tools/messageTools'
import MfpAlertMessage from './alerts/AlertMessage.vue'
import StringTools from '~js/tools/stringTools'

export default {
    name: 'pay-receive',
    computed: {
        StringTools() {
            return StringTools
        },
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        MfpAlertMessage,
        MfpMessage,
        InputMoney
    },
    data() {
        return {
            partial: false,
            wallets: {},
            internalWalletId: 0,
            showAlertWalletDontHaveFound: false,
            messageData: {},
            missingWalletValue: 0
        }
    },
    emits: [
        'pay',
        'hide-pay-receive'
    ],
    props: {
        value: {
            type: Number,
            default: 0
        },
        showPayReceive: {
            type: Boolean,
            default: false
        },
        checkTooltip: {
            type: String,
            required: true,
            default: ''
        },
        walletId: {
            type: Number,
            default: 0
        },
        partialLabel: {
            type: String,
            default: 'Pagamento parcial'
        },
        validateWalletValue: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        pay() {
            if (this.value > 0 && this.internalWalletId > 0) {
                this.$emit('pay', {
                    value: this.value,
                    walletId: this.internalWalletId,
                    partial: this.partial
                })
                this.partial = false
            } else {
                this.messageData = messageTools.infoMessage('Um valor maior que zero e uma carteira deve ser selecionados')
            }
        },
        hidePay() {
            this.partial = false
            this.$emit('hide-pay-receive')
        },
        getMessageMissingWalletValue() {
            let message = 'Falta ' + StringTools.formatFloatValueToBrString(this.missingWalletValue)
            message += ' para poder utilizar essa carteira como pagamento para essa conta.'
            return message
        }
    },
    async mounted() {
        await ApiRouter.wallet.index().then(response => {
            this.wallets = response
        })
    },
    watch: {
        walletId: {
            handler() {
                this.internalWalletId = this.walletId
            }
        },
        internalWalletId: {
            handler() {
                if (this.internalWalletId > 0) {
                    for (let index = 0; index < this.wallets.length; index++) {
                        if (this.wallets[index].id === this.internalWalletId) {
                            const missingValue = this.value - this.wallets[index].amount
                            if (missingValue > 0) {
                                this.showAlertWalletDontHaveFound = true
                                this.missingWalletValue = missingValue
                                return
                            }
                        }
                    }
                }
                this.showAlertWalletDontHaveFound = false
            }
        }
    }
}
</script>

<style scoped>
    @media (max-width: 1000px) {
        .pay-receive {
            flex-direction: column;
        }
        .form-group {
            margin-bottom: 10px;
            width: 100% !important;
            border-radius: 8px !important;
        }
        .switch {
            width: 100% !important;
        }
        .button-group {
            margin-top: 10px !important;
            width: 100% !important;
        }
        .btn {
            border-radius: 8px !important;
            font-size: 20px !important;
            width: 100% !important;
        }
        .money {
            margin-bottom: 10px !important;
        }
        .btn-success {
            margin-bottom: 10px !important;
        }
    }
</style>