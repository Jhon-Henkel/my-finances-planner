<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Carteiras'"/>
                <router-link class="btn btn-success rounded-5" to="/carteiras/cadastrar">
                    <font-awesome-icon :icon="iconEnum.wallet()" class="me-2"/>
                    Nova Carteira
                </router-link>
            </div>
            <divider/>
            <table class="table table-dark table-striped table-sm table-hover table-bordered align-middle">
                <thead class="table-dark">
                <tr>
                    <th class="text-center" scope="col">Carteira</th>
                    <th class="text-center" scope="col">Tipo</th>
                    <th class="text-center" scope="col">Valor Atual</th>
                    <th class="text-center" scope="col">Data Criação</th>
                    <th class="text-center" scope="col">Data Modificação</th>
                    <th class="text-center" scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="wallet in wallets" :key="wallet.id">
                    <td class="text-center">{{ wallet.name }}</td>
                    <td class="text-center">{{ walletEnum.getDescription(wallet.type) }}</td>
                    <td class="text-center" v-if="wallet.amount < 0" v-tooltip="'Cuidado, valor negativo'">
                        {{ stringTools.formatFloatValueToBrString(wallet.amount) }}
                        <font-awesome-icon :icon="iconEnum.triangleExclamation()" class="icon-alert"/>
                    </td>
                    <td class="text-center" v-else>{{ stringTools.formatFloatValueToBrString(wallet.amount) }}</td>
                    <td class="text-center">{{ calendarTools.convertDateDbToBr(wallet.createdAt, false) }}</td>
                    <td class="text-center">{{ calendarTools.convertDateDbToBr(wallet.updatedAt, false) }}</td>
                    <td>
                        <action-buttons
                            :delete-tooltip="'Deletar Carteira'"
                            :tooltip-edit="'Editar Carteira'"
                            :edit-to="'/carteiras/' + wallet.id + '/atualizar'"
                            @delete-clicked="deleteWallet(wallet.id, wallet.name)" />
                    </td>
                </tr>
                </tbody>
            </table>
            <divider/>
            <div class="text-end">
                <h3>Total: {{ stringTools.formatFloatValueToBrString(sumTotalAmount) }}</h3>
            </div>
        </div>
    </div>
</template>

<script>
    import apiRouter from "../../../js/router/apiRouter";
    import walletEnum from "../../../js/enums/walletEnum";
    import stringTools from "../../../js/tools/stringTools";
    import numberTools from "../../../js/tools/numberTools";
    import calendarTools from "../../../js/tools/calendarTools";
    import iconEnum from "../../../js/enums/iconEnum";
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import ActionButtons from "../../components/ActionButtons.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";

    export default {
        name: "WalletView",
        components: {
            MfpMessage,
            MfpTitle,
            Divider,
            ActionButtons,
            LoadingComponent,
        },
        computed: {
            iconEnum() {
                return iconEnum
            },
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
                sumTotalAmount: 0,
                loadingDone: false
            }
        },
        methods: {
            async getWallets() {
                this.loadingDone = false
                this.wallets = await apiRouter.wallet.index()
                this.sumTotalAmount = numberTools.getSumTotalAmount(this.wallets)
                this.loadingDone = true
            },
            async deleteWallet(walletId, walletName) {
                if(confirm("Tem certeza que realmente quer deletar a carteira " + walletName + '?')) {
                    await apiRouter.wallet.delete(walletId).then((response) => {
                        this.messageSuccess('Carteira deletada com sucesso!')
                        this.getWallets()
                    }).catch((response) => {
                        this.messageError('Erro inesperado ao deletar carteira!')
                    })
                }
            },
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, header) {
                this.$refs.message.showAlert(type,message,header)
            }
        },
        mounted() {
            this.getWallets()
        }
    }
</script>

<style scoped>
    .icon-alert {
         color: #fdd200;
         font-size: 15px;
         top: 50%;
    }
</style>