<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === 0"/>
        <div v-show="loadingDone === 1">
            <div class="nav mt-2 justify-content-end">
                <mfp-title :title="'Configurações'"/>
            </div>
            <divider/>
            <input-money :value="user.salary" :title="'Salário Bruto'" @input-money="user.salary = $event"/>
            <form class="was-validated">
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="email">
                                E-mail
                            </label>
                            <input type="email" class="form-control" v-model="user.email" id="email" required>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label" for="name">
                                Nome
                            </label>
                            <input type="text" class="form-control" v-model="user.name" id="name" required>
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
            <bottom-buttons :show-button-cancel="false"
                            :button-success-text="'Salvar Configurações'"
                            @btn-clicked="updateConfigs"/>
        </div>
    </div>
</template>

<script>
import LoadingComponent from '../../components/LoadingComponent.vue'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import InputMoney from '../../components/inputMoneyComponent.vue'
import BottomButtons from '../../components/BottomButtons.vue'
import iconEnum from '../../../js/enums/iconEnum'
import MfpMessage from '../../components/MessageAlert.vue'
import ApiRouter from '../../../js/router/apiRouter'
import RequestTools from '../../../js/tools/requestTools'
import { userAuthStore } from '../../store/auth'
import messageTools from '../../../js/tools/messageTools'

const auth = userAuthStore()

export default {
    name: 'ConfigurationsView',
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
            id: 0,
            user: {
                salary: 0,
                name: '',
                email: '',
                password: ''
            },
            newPassword: '',
            newPasswordConfirmation: '',
            alterPassword: false,
            messageData: {}
        }
    },
    methods: {
        async updateConfigs() {
            if (RequestTools.isApplicationInDemoMode() === true) {
                const message = 'Aplicação em mode demo não permite alterar as configurações!'
                this.messageData = messageTools.warningMessage(message)
                return
            }
            if (this.alterPassword === true) {
                if (this.newPassword !== this.newPasswordConfirmation) {
                    this.messageData = messageTools.errorMessage('Senhas não conferem!')
                    return
                }
                this.user.password = this.newPassword
            }
            await ApiRouter.user.update(this.id, this.user).then(() => {
                this.messageData = messageTools.successMessage('Faça login novamente.')
            }).catch(() => {
                this.messageData = messageTools.errorMessage('Erro ao atualizar dados do usuário!')
            })
        }
    },
    async mounted() {
        this.id = auth.user.id
        await ApiRouter.user.show(this.id).then((response) => {
            this.user = response
            this.loadingDone = this.loadingDone + 1
        }).catch(() => {
            this.messageData = messageTools.errorMessage('Erro ao carregar dados do usuário!')
        })
    }
}
</script>