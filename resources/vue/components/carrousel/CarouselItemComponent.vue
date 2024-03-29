<template>
    <div class="carousel-item" :class="active ? 'active' : ''">
        <div class="row card-body text-center">
            <div class="col-1"></div>
            <div class="col-10">
                <h4 class="card-title">
                    <span>{{ getMonthName() }}</span>
                </h4>
                <div class="col-12">
                    <hr class="mfp-card-divider">
                </div>
                <div class="resume-content">
                    <div class="row">
                        <div class="col-12">
                            <div class="row" v-if="! haveInvoiceItens()">
                                <div class="col-12">
                                    <span>Não há despesas para este mês</span>
                                </div>
                                <div class="col-12">
                                    <hr class="mfp-card-divider">
                                </div>
                            </div>
                            <div class="row mt-1" v-else v-for="expense in invoices" :key="expense.id">
                                <div class="col-10" v-if="mustShowItem(expense)">
                                    <div class="row">
                                        <div class="col-7 d-flex justify-content-start align-items-start">
                                            <span>{{ expense.name }}</span>
                                        </div>
                                        <div class="col-5 d-flex justify-content-start align-items-start">
                                            <mfp-expires-date-badge :installment="expense"
                                                                    :show-calendar-icon="true"
                                                                    :always-success-badge="installment !== 'firstInstallment'"/>
                                        </div>
                                    </div>
                                    <div class="row text-sm">
                                        <div class="col-7 d-flex justify-content-start align-items-start">
                                            <span>
                                                Valor:
                                                {{ StringTools.formatFloatValueToBrString(expense[installment]) }}
                                            </span>
                                        </div>
                                        <div class="col-5 d-flex justify-content-start align-items-start">
                                            <span v-if="expense.remainingInstallments === 0" v-tooltip="'Valor Fixo'">
                                                Valor Fixo
                                            </span>
                                            <span v-else v-tooltip="'Falta ' + StringTools.formatFloatValueToBrString(expense.totalRemainingValue)">
                                                Restam: {{ expense.remainingInstallments }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-center" v-if="mustShowItem(expense)">
                                    <div class="dropdown-center">
                                        <button class="btn btn-outline-success"
                                                type="button"
                                                data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                            <font-awesome-icon :icon="IconEnum.ellipsisVertical()"/>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li v-if="useCheckButton">
                                                <button class="dropdown-item check-button"
                                                        @click="this.$emit('check-clicked', expense)"
                                                        v-tooltip="'Ok para o próximo'">
                                                    <font-awesome-icon :icon="IconEnum.check()" />
                                                    Ok
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item edit-button"
                                                        @click="this.$emit('expense-edit', expense)"
                                                        v-tooltip="'Editar'">
                                                    <font-awesome-icon :icon="IconEnum.editIcon()" />
                                                    Editar
                                                </button>
                                            </li>
                                            <li>
                                                <button class="dropdown-item delete-button"
                                                        @click="this.$emit('expense-delete', expense)"
                                                        v-tooltip="'Apagar'">
                                                    <font-awesome-icon :icon="IconEnum.trashIcon()" />
                                                    Apagar
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-1" v-if="mustShowItem(expense)"></div>
                                <div class="col-12" v-if="mustShowItem(expense)">
                                    <hr class="mfp-card-divider">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" v-if="haveInvoiceItens()">
                    <div class="col-6">
                        <span>Total</span>
                    </div>
                    <div class="col-6">
                        <span>{{ getTotalInvoiceValue() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-1"></div>
        </div>
    </div>
</template>

<script>
import CalendarTools from '~js/tools/calendarTools'
import StringTools from '~js/tools/stringTools'
import IconEnum from '~js/enums/iconEnum'
import MfpExpiresDateBadge from '../date/ExpiresDateBadge.vue'

export default {
    name: 'MfpInvoiceCarouselItem',
    components: { MfpExpiresDateBadge },
    computed: {
        IconEnum() {
            return IconEnum
        },
        StringTools() {
            return StringTools
        },
        CalendarTools() {
            return CalendarTools
        }
    },
    props: {
        months: {
            type: Array,
            required: true
        },
        invoices: {
            type: Array,
            required: true
        },
        installment: {
            type: String,
            required: true
        },
        active: {
            type: Boolean,
            required: false,
            default: false
        },
        useCheckButton: {
            type: Boolean,
            required: false,
            default: false
        }
    },
    emits: [
        'expense-edit',
        'expense-delete',
        'check-clicked'
    ],
    methods: {
        getMonthName() {
            switch (this.installment) {
            case 'firstInstallment':
                return CalendarTools.getMonthNameByNumber(this.months[0])
            case 'secondInstallment':
                return CalendarTools.getMonthNameByNumber(this.months[1])
            case 'thirdInstallment':
                return CalendarTools.getMonthNameByNumber(this.months[2])
            case 'fourthInstallment':
                return CalendarTools.getMonthNameByNumber(this.months[3])
            case 'fifthInstallment':
                return CalendarTools.getMonthNameByNumber(this.months[4])
            case 'sixthInstallment':
                return CalendarTools.getMonthNameByNumber(this.months[5])
            }
        },
        getTotalInvoiceValue() {
            let total = 0
            this.invoices.forEach(invoice => {
                total += invoice[this.installment]
            })
            return StringTools.formatFloatValueToBrString(total)
        },
        haveInvoiceItens() {
            let haveItens = false
            this.invoices.forEach(invoice => {
                if (invoice[this.installment] > 0) {
                    haveItens = true
                }
            })
            return haveItens
        },
        mustShowItem(expense) {
            return expense[this.installment] !== 0
        }
    }
}
</script>