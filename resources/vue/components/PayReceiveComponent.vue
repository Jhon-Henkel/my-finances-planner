<template>
    <mfp-message ref="message"/>
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
            <button class="btn btn-success rounded-5 me-2" @click="pay" v-tooltip="checkTooltip">
                <font-awesome-icon :icon="iconEnum.check()"/>
            </button>
            <button class="btn btn-danger rounded-5" @click="hidePay" v-tooltip="'Cancelar'">
                <font-awesome-icon :icon="iconEnum.xMark()"/>
            </button>
        </div>
    </div>
</template>

<script>
    import InputMoney from "./inputMoneyComponent.vue";
    import iconEnum from "../../js/enums/iconEnum";
    import ApiRouter from "../../js/router/apiRouter";
    import MfpMessage from "./MessageAlert.vue";
    import MessageEnum from "../../js/enums/messageEnum";

    export default {
        name: 'pay-receive',
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            MfpMessage,
            InputMoney
        },
        data() {
            return {
                partial: false,
                wallets: {},
                internalWalletId: 0
            }
        },
        emits: [
            'pay',
            'hide-pay-receive'
        ],
        props:{
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
                    this.showMessage(
                        MessageEnum.alertTypeInfo(),
                        'Um valor maior que zero e uma carteira deve ser selecionados',
                        'Informação'
                    )
                }
            },
            hidePay() {
                this.partial = false
                this.$emit('hide-pay-receive')
            },
            showMessage(type, message, header) {
                this.$refs.message.showAlert(type,message,header)
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