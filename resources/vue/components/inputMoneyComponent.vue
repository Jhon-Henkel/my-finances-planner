<template>
    <label class="form-label" for="input-money">
        {{ title }}
    </label>
    <div class="input-group">
        <span class="input-group-text" id="basic-addon1">
            <font-awesome-icon :icon="iconEnum.moneyBr()" />
        </span>
        <input class="form-control v-money"
               id="input-money"
               v-money="{precision, decimal, thousands, prefix, suffix}"
               @change="change"
               :value="formattedValue"
               type="tel"
               required>
    </div>
</template>

<script>
    import money from '../../directives/moneyMask/moneyMask'
    import defaults from '../../directives/moneyMask/options'
    import {format, unformat} from '../../directives/moneyMask/util'
    import iconEnum from "../../js/enums/iconEnum";

    export default {
        name: 'inputMoney',
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        emits: [
            'input-money'
        ],
        props: {
            title: {
                type: String,
                default: 'Valor'
            },
            value: {
                required: true,
                type: [Number, String],
                default: 0
            },
            masked: {
                type: Boolean,
                default: false
            },
            precision: {
                type: Number,
                default: () => defaults.precision
            },
            decimal: {
                type: String,
                default: () => defaults.thousands
            },
            thousands: {
                type: String,
                default: () => defaults.decimal
            },
            prefix: {
                type: String,
                default: () => defaults.prefix
            },
            suffix: {
                type: String,
                default: () => defaults.suffix
            }
        },
        directives: {
            money
        },
        data () {
            return {
                formattedValue: ''
            }
        },
        watch: {
            value: {
                immediate: true,
                handler (newValue, oldValue) {
                    let formatted = format(newValue, this.$props)
                    if (formatted !== this.formattedValue) {
                        this.formattedValue = formatted
                    }
                }
            }
        },
        methods: {
            change (event) {
                this.$emit(
                    'input-money',
                    this.masked ? event.target.value : unformat(event.target.value, this.precision)
                )
            }
        }
    }
</script>