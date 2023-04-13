<template>
    <div class="base-container">
        <div class="nav mt-2 justify-content-end">
            <h3 id="title">Carteiras</h3>
            <router-link class="btn btn-success rounded-5"
                         @click="insertWallet"
                        data-toggle="tooltip"
                        title="Editar"
                        data-bs-placement="left"
                        to="/carteiras/cadastrar">
                <span class="material-symbols-outlined me-2">paid</span>
                Nova Carteira
            </router-link>
        </div>
        <hr>
        <div class="mt-4">
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center" scope="col">Carteira</th>
                        <th class="text-center" scope="col">Tipo</th>
                        <th class="text-center" scope="col">Valor Atual</th>
                        <th class="text-center" scope="col">Data Criação</th>
                        <th class="text-center" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="wallet in wallets" :key="wallet.id">
                        <td class="text-center">{{ wallet.name }}</td>
                        <td class="text-center">{{ walletEnum.getDescription(wallet.type) }}</td>
                        <td class="text-center text-red" v-if="wallet.amount < 0">
                            <span class="material-symbols-outlined icon-alert"
                                  data-toggle="tooltip"
                                  title="Cuidado, valor negativo"
                                  data-bs-placement="left">
                                warning
                            </span>
                            {{ stringTools.formatDbValueToBrString(wallet.amount) }}
                        </td>
                        <td class="text-center" v-else>{{ stringTools.formatDbValueToBrString(wallet.amount) }}</td>
                        <td class="text-center">{{ calendarTools.convertDateToBr(wallet.createdAt, false) }}</td>
                        <td class="text-center action-buttons">
                            <button class="btn btn-sm btn-success rounded-5 me-1"
                                    @click="editWallet(wallet.id)"
                                    data-toggle="tooltip"
                                    title="Editar"
                                    data-bs-placement="left">
                                <span class="material-symbols-outlined">edit</span>
                            </button>
                            <button class="btn btn-sm btn-danger rounded-5"
                                    @click="deleteWallet(wallet.id)"
                                    data-toggle="tooltip"
                                    title="Editar"
                                    data-bs-placement="right">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <hr class="mt-4">
        <div class="text-end">
            <h3>Total: {{ stringTools.formatDbValueToBrString(sumTotalAmount) }}</h3>
        </div>
    </div>
</template>

<script>
    import apiRouter from "../../../js/router/apiRouter";
    import walletEnum from "../../../js/enums/walletEnum";
    import stringTools from "../../../js/tools/stringTools";
    import numberTools from "../../../js/tools/numberTools";
    import calendarTools from "../../../js/tools/calendarTools";

    export default {
        name: "WalletView",
        computed: {
            walletEnum() {
                return walletEnum
            },
            calendarTools() {
                return calendarTools
            },
            stringTools() {
                return stringTools
            }
        },
        data() {
            return {
                wallets: {},
                sumTotalAmount: 0
            }
        },
        methods: {
            async getWallets() {
                this.wallets = await apiRouter.wallet.index()
                this.sumTotalAmount = numberTools.getSumTotalAmount(this.wallets)
            },
            async deleteWallet(walletId) {

            },
            async editWallet(walletId) {

            },
            async insertWallet() {

            },
            enableTooltips() {
                $(document).ready(function() {
                    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
                });
            }
        },
        mounted() {
            this.getWallets()
            this.enableTooltips()
        }
    }
</script>

<style scoped>
 .icon-alert {
     color: #fdd200;
     font-size: 19px;
     top: 50%;
 }
</style>