<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <loading-component v-show="loadingDone === 0"/>
        <div class="card text-center login-box glass" v-if="loadingDone === 1">
            <mfp-title class="title" :title="'Login'"/>
            <div class="card-body">
                <form class="form-horizontal" @submit="login">
                    <divider/>
                    <div class="text-black">
                        <div class="input-group">
                            <span class="input-group-text">
                                <font-awesome-icon :icon="iconEnum.user()"/>
                            </span>
                            <div class="form-floating">
                                <input type="email"
                                       v-model="user.email"
                                       class="form-control"
                                       id="user-email"
                                       placeholder="Usuário"
                                       required>
                                <label for="user-email">Usuário</label>
                            </div>
                        </div>
                        <div class="input-group mt-3">
                            <span class="input-group-text">
                                <font-awesome-icon :icon="iconEnum.key()"/>
                            </span>
                            <div class="form-floating">
                                <input type="password"
                                       v-model="user.password"
                                       class="form-control"
                                       id="user-password"
                                       placeholder="Senha"
                                       min="4"
                                       required>
                                <label for="user-password">Senha</label>
                            </div>
                        </div>
                    </div>
                    <divider/>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-full">
                            <font-awesome-icon :icon="iconEnum.unlock()" flip="horizontal" class="me-2"/>
                            <span class="text-button-login">Entrar</span>
                        </button>
                    </div>
                </form>
                <div class="form-group" v-show="isAppInDemoMode">
                    <a href="/sobre" class="btn btn-info btn-full mt-3">
                        <font-awesome-icon :icon="iconEnum.circleInfo()" flip="horizontal" class="me-2"/>
                        <span class="text-button-login">Sobre</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import iconEnum from '../../../js/enums/iconEnum'
import RouterNonAuthenticated from '../../../js/router/routerNonAuthenticated'
import { HttpStatusCode } from 'axios'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'
import MfpMessage from '../../components/MessageAlert.vue'
import MessageEnum from '../../../js/enums/messageEnum'
import RequestTools from '../../../js/tools/requestTools'
import LoadingComponent from '../../components/LoadingComponent.vue'
import apiRouter from '../../../js/router/apiRouter'
import Router from '../../../js/router'
import { userAuthStore } from '../../store/auth'

const auth = userAuthStore()

export default {
    name: 'LoginView',
    components: {
        LoadingComponent,
        MfpMessage,
        MfpTitle,
        Divider
    },
    data() {
        return {
            user: {},
            loadingDone: 0,
            isAppInDemoMode: RequestTools.isApplicationInDemoMode()
        }
    },
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    methods: {
        async login(event) {
            event.preventDefault()
            await RouterNonAuthenticated.auth.makeLogin(this.populateDate()).then((response) => {
                if (response.status === HttpStatusCode.Ok) {
                    auth.setToken(response.data.token)
                    auth.setUser(response.data.user)
                    Router.push({ name: 'dashboard' })
                } else {
                    this.showMessage(
                        MessageEnum.alertTypeError(),
                        'Campo "Algo deu errado ao efetuar seu login!',
                        'Ocorreu um erro!'
                    )
                }
            }).catch((response) => {
                this.showMessage(
                    MessageEnum.alertTypeError(),
                    response.response.data.message,
                    'Ocorreu um erro!'
                )
            })
        },
        populateDate() {
            return {
                email: this.user.email,
                password: this.user.password
            }
        },
        async checkUserIsLogged() {
            const isUserLogged = auth.isAuthUser()
            if (isUserLogged) {
                await Router.push({ name: 'dashboard' })
                this.loadingDone = 1
                return
            }
            this.loadingDone = 1
            await apiRouter.userActions.logout()
            await Router.push({ name: 'login' })
        },
        showMessage(type, message, title) {
            this.$refs.message.showAlert(type, message, title)
        }
    },
    async mounted() {
        this.loadingDone = 0
        await this.checkUserIsLogged()
        if (RequestTools.isApplicationInDemoMode()) {
            this.user.email = import.meta.env.VITE_DEMO_USER
            this.user.password = import.meta.env.VITE_DEMO_PASSWORD
        }
    }
}
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .card-body {
        padding: 0;
        margin: 0 20px 25px 20px;
    }
    .title {
        padding: 0;
        margin: 10px 0 0;
    }
    .login-box {
        width: 30rem;
        margin: 18vh auto 0 auto;
        top: 3vh;
        padding: 1vh;
        height:auto;
        max-width: 70vh;
    }
    .input-group {
        box-shadow: 0 0 0.5em $black-color;
    }
    .base-container hr {
        height: 8px;
        border: 0;
        border-radius: 15px 15px 15px 15px;
        box-shadow: 0 0 0.5em $black-color;
        background-color: $divider-component-color;
    }
    .input-group-text {
        border: 0;
        background-color: $icon-input-background-icon;
    }
    .text-button-login {
        font-size: 20px;
    }
    @media (max-width: 1000px) {
        .login-box {
            width: 100%;
            margin-top: 50%;
            top: 0;
            padding: 0;
            height:auto;
            max-width: 100%;
        }
    }
</style>