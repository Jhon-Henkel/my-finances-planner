<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === 0"/>
        <div v-show="loadingDone === 2">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Configurações'"/>
            </div>
            <divider/>
            <input-money :value="salary" :title="'Salário Bruto'" @input-money="salary = $event"/>
            <form class="was-validated">
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="email">
                                E-mail
                            </label>
                            <input type="email" class="form-control" v-model="email" id="email" required>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="name">
                                Nome
                            </label>
                            <input type="text" class="form-control" v-model="name" id="name" required>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="alter-password">
                                Alterar Senha
                            </label>
                            <input class="form-check-input"
                                   v-model="alterPassword"
                                   type="checkbox"
                                   role="switch"
                                   id="alter-password">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3" v-if="alterPassword === true">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="new-password">
                                Nova Senha
                            </label>
                            <input type="password"
                                   class="form-control"
                                   v-model="newPassword"
                                   id="new-password"
                                   required>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label" for="new-password-confirmation">
                                Confirme a senha
                            </label>
                            <input type="password"
                                   class="form-control"
                                   v-model="newPasswordConfirmation"
                                   id="new-password-confirmation"
                                   required>
                        </div>
                        <div v-show="newPassword !== newPasswordConfirmation && newPasswordConfirmation.length > 0">
                            <div class="alert alert-danger mt-2 text-center" role="alert">
                                Senhas não conferem!
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <divider/>
            <bottom-buttons redirect-to="/dashboard"
                            :button-cancel-text="'Voltar para a Dashboard'"
                            :button-cancel-icon="iconEnum.back()"
                            :button-success-text="'Salvar Configurações'"
                            @btn-clicked="updateConfigs"/>
        </div>
    </div>
</template>

<script>
    import LoadingComponent from "../../components/LoadingComponent.vue";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import InputMoney from "../../components/inputMoneyComponent.vue";
    import BottomButtons from "../../components/BottomButtons.vue";
    import iconEnum from "../../../js/enums/iconEnum";
    import apiRouter from "../../../js/router/apiRouter";
    import MessageEnum from "../../../js/enums/messageEnum";
    import MfpMessage from "../../components/MessageAlert.vue";

    export default {
        name: "ConfigurationsView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {
            MfpMessage,
            BottomButtons,
            InputMoney,
            MfpTitle,
            Divider,
            LoadingComponent
        },
        data() {
            return {
                loadingDone: 0,
                salary: 0,
                name: '',
                email: '',
                salaryDb: 0,
                nameDb: '',
                emailDb: '',
                newPassword: '',
                newPasswordConfirmation: '',
                alterPassword: false,
            }
        },
        methods: {
            updateConfigs() {
                let error = null;
                if (this.salary !== this.salaryDb) {
                    const data = {value: this.salary}
                    apiRouter.configurations.update('salary', data).then(() => {
                        this.salaryDb = this.salary;
                    }).catch(() => {
                        error = error + ' Erro ao atualizar o salário!'
                    });
                }
                if (error) {
                    this.messageError(error);
                    return
                }
                this.messageSuccess('Configurações atualizadas com sucesso!');
            },
            messageError(message) {
                this.showMessage(MessageEnum.alertTypeError(), message, 'Ocorreu um erro!')
            },
            messageSuccess(message) {
                this.showMessage(MessageEnum.alertTypeSuccess(), message, 'Sucesso!')
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
            }
        },
        async mounted() {
            this.loadingDone = 1;
            await apiRouter.configurations.getSalary().then(response => {
                this.salary = parseFloat(response.value)
                this.salaryDb = parseFloat(response.value)
                this.loadingDone = this.loadingDone + 1
            });
        }
    }
</script>

<style scoped>

</style>