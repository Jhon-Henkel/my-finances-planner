<template>
    <div class="base-container">
        <div class="nav mt-2 justify-content-end">
            <h3 id="title">Carteiras</h3>
            <button class="btn btn-success rounded-5"
                    @click="insertWallet"
                    data-toggle="tooltip"
                    title="Editar"
                    data-bs-placement="left">
                <span class="material-symbols-outlined me-2">paid</span>
                Nova Carteira
            </button>
        </div>
        <hr>
        <div class="mt-4">
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">Carteira</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Valor Atual</th>
                        <th class="text-center">Data Criação</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="wallet in wallets" :key="wallet.id">
                        <td class="text-center">{{ wallet.name }}</td>
                        <td class="text-center">{{ wallet.type }}</td>
                        <td class="text-center">{{ stringTools.formatValueToBr(wallet.amount) }}</td>
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
                <tfoot>
                    fazer somatório por tipo de conta
                </tfoot>
            </table>
        </div>
    </div>
</template>

<script>
    import apiRouter from "../../js/router/apiRouter";
    import stringTools from "../../js/tools/stringTools";
    import calendarTools from "../../js/tools/calendarTools";

    export default {
        name: "WalletView",
        computed: {
            calendarTools() {
                return calendarTools
            },
            stringTools() {
                return stringTools
            }
        },
        data() {
            return {
                wallets: {}
            }
        },
        methods: {
            async getWallets() {
                this.wallets = await apiRouter.wallet.index();
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

</style>