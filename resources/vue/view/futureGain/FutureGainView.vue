<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <mfp-nav-component>
                <mfp-title :title="'Ganhos Futuros'"/>
                <mfp-router-link-button :icon="iconEnum.sackDollar()" redirect-to="/ganhos-futuros/cadastrar">
                    Novo Ganho Futuro
                </mfp-router-link-button>
            </mfp-nav-component>
            <divider/>
            <div class="card glass success balance-card" v-if="! requestTools.device.isMobile()">
                <div class="card-body text-center">
                    <div class="card-text">
                        <div class="table-responsive-lg">
                            <table class="table table-transparent table-striped table-sm table-hover align-middle table-borderless">
                                <thead class="text-center">
                                    <tr class="text-center">
                                        <th><font-awesome-icon :icon="iconEnum.calendarCheck()"/></th>
                                        <th>Descrição</th>
                                        <th>Carteira</th>
                                        <th scope="col" v-for="(month, index) in months" :key="index">
                                            {{ CalendarTools.getMonthNameByNumber(month) }}
                                        </th>
                                        <th>Restam</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody class="table-body-hover">
                                    <tr v-show="futureGains.length === 0" class="text-center">
                                        <td colspan="11">Nenhum ganho cadastrado ainda!</td>
                                    </tr>
                                    <tr v-for="gain in futureGains" :key="gain.id" class="text-center">
                                        <td>
                                            <mfp-expires-date-badge :installment="gain"/>
                                        </td>
                                        <td class="text-start">{{ gain.name }}</td>
                                        <td class="text-start">{{ gain.countName }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.firstInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.secondInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.thirdInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.fourthInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.fifthInstallment) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(gain.sixthInstallment) }}</td>
                                        <td v-if="gain.remainingInstallments === 0" v-tooltip="'Ganho Fixo'">Fixo</td>
                                        <td v-else v-tooltip="StringTools.formatFloatValueToBrString(gain.totalRemainingValue)">
                                            {{ gain.remainingInstallments }}
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center">
                                            <div class="dropdown-center">
                                                <button class="btn btn-outline-success"
                                                        type="button"
                                                        data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                    <font-awesome-icon :icon="iconEnum.ellipsisVertical()"/>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <button class="dropdown-item check-button"
                                                                @click="showReceiveGainForm(gain)"
                                                                v-tooltip="'Ok para o próximo'">
                                                            <font-awesome-icon :icon="iconEnum.check()" />
                                                            Ok
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item edit-button"
                                                                @click="editExpense(gain)"
                                                                v-tooltip="'Editar'">
                                                            <font-awesome-icon :icon="iconEnum.editIcon()" />
                                                            Editar
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item delete-button"
                                                                @click="deleteGain(gain)"
                                                                v-tooltip="'Apagar'">
                                                            <font-awesome-icon :icon="iconEnum.trashIcon()" />
                                                            Apagar
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="text-center border-table">
                                        <td colspan="3">Total</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.firstMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.secondMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.thirdMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.fourthMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.fifthMonth) }}</td>
                                        <td>{{ StringTools.formatFloatValueToBrString(totalPerMonth.sixthMonth) }}</td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <mfp-carousel v-else>
                <mfp-invoice-carousel-item installment="firstInstallment"
                                           :invoices="futureGains"
                                           :months="months"
                                           :active="true"
                                           :useCheckButton="true"
                                           @expense-edit="editExpense($event)"
                                           @expense-delete="deleteGain($event)"
                                           @check-clicked="showReceiveGainForm($event)"/>
                <mfp-invoice-carousel-item installment="secondInstallment"
                                           :invoices="futureGains"
                                           :months="months"
                                           :useCheckButton="true"
                                           @expense-edit="editExpense($event)"
                                           @expense-delete="deleteGain($event)"
                                           @check-clicked="showReceiveGainForm($event)"/>
                <mfp-invoice-carousel-item installment="thirdInstallment"
                                           :invoices="futureGains"
                                           :months="months"
                                           :useCheckButton="true"
                                           @expense-edit="editExpense($event)"
                                           @expense-delete="deleteGain($event)"
                                           @check-clicked="showReceiveGainForm($event)"/>
                <mfp-invoice-carousel-item installment="fourthInstallment"
                                           :invoices="futureGains"
                                           :months="months"
                                           :useCheckButton="true"
                                           @expense-edit="editExpense($event)"
                                           @expense-delete="deleteGain($event)"
                                           @check-clicked="showReceiveGainForm($event)"/>
                <mfp-invoice-carousel-item installment="fifthInstallment"
                                           :invoices="futureGains"
                                           :months="months"
                                           :useCheckButton="true"
                                           @expense-edit="editExpense($event)"
                                           @expense-delete="deleteGain($event)"
                                           @check-clicked="showReceiveGainForm($event)"/>
                <mfp-invoice-carousel-item installment="sixthInstallment"
                                           :invoices="futureGains"
                                           :months="months"
                                           :useCheckButton="true"
                                           @expense-edit="editExpense($event)"
                                           @expense-delete="deleteGain($event)"
                                           @check-clicked="showReceiveGainForm($event)"/>
            </mfp-carousel>
            <pay-receive :show-pay-receive="showReceiveGain"
                         :value="receiveGainValue"
                         :check-tooltip="'Receber Ganho'"
                         :wallet-id="receiveGainWalletId"
                         :partial-label="'Receber Parcial'"
                         @hide-pay-receive="showReceiveGain = false"
                         @pay="receiveGain($event)">
                <span class="mb-1">
                    Receber Ganho <strong class="">{{ receiveGainName }}</strong> do mês {{ getNextGainMonth() }}
                </span>
            </pay-receive>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card glass balance-card card-resume balance-card-resume">
                        <div class="card-body text-center">
                            <h4 class="card-title">
                                <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                                Resumo
                            </h4>
                            <hr>
                            <div class="card-text card-text-resume">
                                <div class="row">
                                    <div class="col-12">
                                        <h6>Total previsto no período</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        {{ StringTools.formatFloatValueToBrString(totalPerMonth.total) }}
                                    </div>
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
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import iconEnum from '~js/enums/iconEnum'
import CalendarTools from '~js/tools/calendarTools'
import ApiRouter from '~js/router/apiRouter'
import StringTools from '~js/tools/stringTools'
import NumberTools from '~js/tools/numberTools'
import Divider from '~vue-component/DividerComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpMessage from '~vue-component/MessageAlert.vue'
import PayReceive from '~vue-component/PayReceiveComponent.vue'
import messageTools from '~js/tools/messageTools'
import MfpExpiresDateBadge from '~vue-component/date/ExpiresDateBadge.vue'
import MfpRouterLinkButton from '~vue-component/buttons/RouterLinkButtonComponent.vue'
import MfpNavComponent from '~vue-component/nav/NavComponent.vue'
import requestTools from '~js/tools/requestTools'
import MfpCarousel from '~vue-component/carrousel/CarouselComponent.vue'
import MfpInvoiceCarouselItem from '~vue-component/carrousel/CarouselItemComponent.vue'
import Router from '~js/router'

export default {
    name: 'FutureGainView',
    computed: {
        requestTools() {
            return requestTools
        },
        StringTools() {
            return StringTools
        },
        CalendarTools() {
            return CalendarTools
        },
        iconEnum() {
            return iconEnum
        }
    },
    components: {
        MfpInvoiceCarouselItem,
        MfpCarousel,
        MfpNavComponent,
        MfpRouterLinkButton,
        MfpExpiresDateBadge,
        PayReceive,
        MfpMessage,
        MfpTitle,
        Divider,
        LoadingComponent
    },
    data() {
        return {
            loadingDone: false,
            months: [],
            totalPerMonth: {
                firstMonth: 0,
                secondMonth: 0,
                thirdMonth: 0,
                fourthMonth: 0,
                fifthMonth: 0,
                sixthMonth: 0,
                total: 0
            },
            receiveGainValue: 0,
            receiveGainWalletId: 0,
            receiveGainId: 0,
            receiveGainName: '',
            showReceiveGain: false,
            futureGains: [],
            messageData: {}
        }
    },
    methods: {
        async updateFutureGainsList() {
            await ApiRouter.futureGain.getNextSixMonthsGains().then(response => {
                this.loadingDone = false
                this.futureGains = response
                this.calculateTotalPerMonth()
                this.loadingDone = true
            }).catch(() => {
                this.messageData = messageTools.errorMessage('Não foi possível carregar os ganhos futuros!')
            })
        },
        calculateTotalPerMonth() {
            const totalPerMonthCount = NumberTools.calculateTotalPerMonthInvoiceItem(this.futureGains)
            this.totalPerMonth.firstMonth = totalPerMonthCount.firstMonth
            this.totalPerMonth.secondMonth = totalPerMonthCount.secondMonth
            this.totalPerMonth.thirdMonth = totalPerMonthCount.thirdMonth
            this.totalPerMonth.fourthMonth = totalPerMonthCount.fourthMonth
            this.totalPerMonth.fifthMonth = totalPerMonthCount.fifthMonth
            this.totalPerMonth.sixthMonth = totalPerMonthCount.sixthMonth
            this.totalPerMonth.total = totalPerMonthCount.total
        },
        async deleteGain(event) {
            if (confirm('Tem certeza que realmente quer deletar o ganho ' + event.name + '?')) {
                await ApiRouter.futureGain.delete(event.id).then(() => {
                    this.messageData = messageTools.successMessage('Ganho deletado com sucesso!')
                    this.updateFutureGainsList()
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível deletar o ganho!')
                })
            }
        },
        async receiveGain(event) {
            const partial = event.partial ? ' de forma parcial' : ''
            let confirmMessage = 'Você confirma o recebimento do ganho '
            confirmMessage = confirmMessage + '"' + this.receiveGainName + '"'
            confirmMessage = confirmMessage + partial
            confirmMessage = confirmMessage + ' no valor de ' + StringTools.formatFloatValueToBrString(event.value)
            if (confirm(confirmMessage + '?')) {
                const object = {
                    walletId: event.walletId,
                    value: event.value,
                    partial: event.partial
                }
                await ApiRouter.futureGain.receive(this.receiveGainId, object).then(() => {
                    this.messageData = messageTools.successMessage('Ganho recebido com sucesso!')
                    this.updateFutureGainsList()
                    this.showReceiveGain = false
                }).catch(() => {
                    this.messageData = messageTools.errorMessage('Não foi possível receber o ganho!')
                })
            }
        },
        showReceiveGainForm(event) {
            this.receiveGainValue = this.getNextGainValue(event)
            this.receiveGainWalletId = event.countId
            this.receiveGainId = event.id
            this.receiveGainName = event.name
            this.showReceiveGain = true
        },
        getNextGainValue(gain) {
            if (gain.firstInstallment) {
                return gain.firstInstallment
            } else if (gain.secondInstallment) {
                return gain.secondInstallment
            } else if (gain.thirdInstallment) {
                return gain.thirdInstallment
            } else if (gain.fourthInstallment) {
                return gain.fourthInstallment
            } else if (gain.fifthInstallment) {
                return gain.fifthInstallment
            } else if (gain.sixthInstallment) {
                return gain.sixthInstallment
            }
        },
        showCheckButton(gain) {
            if (
                !gain.firstInstallment &&
                    !gain.secondInstallment &&
                    !gain.thirdInstallment &&
                    !gain.fourthInstallment &&
                    !gain.fifthInstallment &&
                    !gain.sixthInstallment
            ) {
                return false
            }
            return true
        },
        editExpense(event) {
            Router.push('/ganhos-futuros/' + event.id + '/atualizar')
        },
        getNextGainMonth() {
            const id = this.receiveGainId
            if (id === 0) {
                return
            }
            let month = ''
            this.futureGains.forEach(gain => {
                if (gain.id === id) {
                    if (gain.firstInstallment > 0) {
                        month = CalendarTools.getMonthNameByNumber(this.months[0])
                    } else if (gain.secondInstallment > 0) {
                        month = CalendarTools.getMonthNameByNumber(this.months[1])
                    } else if (gain.thirdInstallment > 0) {
                        month = CalendarTools.getMonthNameByNumber(this.months[2])
                    } else if (gain.fourthInstallment > 0) {
                        month = CalendarTools.getMonthNameByNumber(this.months[3])
                    } else if (gain.fifthInstallment > 0) {
                        month = CalendarTools.getMonthNameByNumber(this.months[4])
                    } else if (gain.sixthInstallment > 0) {
                        month = CalendarTools.getMonthNameByNumber(this.months[5])
                    }
                }
            })
            return month
        }
    },
    async mounted() {
        window.location.href = '/v2/ganhos-futuros'
        this.thisMonth = CalendarTools.getThisMonth()
        this.months = CalendarTools.getNextSixMonths(this.thisMonth)
        await this.updateFutureGainsList()
    }
}
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .border-table {
        border-top: 2px solid $table-line-divider-color;
    }
    .card-text-resume {
        font-size: 1.5rem;
    }
</style>