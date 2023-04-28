<template>
    <div class="base-container">
        <mfp-message ref="message"/>
        <div class="card text-center login-box glass">
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
            </div>
        </div>
    </div>
</template>

<script>
    import iconEnum from "../../../js/enums/iconEnum";
    import RouterNonAuthenticated from "../../../js/router/routerNonAuthenticated";
    import {HttpStatusCode} from "axios";
    import routerNonAuthenticated from "../../../js/router/routerNonAuthenticated";
    import Divider from "../../components/DividerComponent.vue";
    import MfpTitle from "../../components/TitleComponent.vue";
    import MfpMessage from "../../components/MessageAlert.vue";
    import MessageEnum from "../../../js/enums/messageEnum";

    export default {
        name: "LoginView",
        components: {
            MfpMessage,
            MfpTitle,
            Divider,
        },
        data() {
            return {
                user: {},
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
                await RouterNonAuthenticated.login.makeLogin(this.populateDate()).then((response) => {
                        if (response.status === HttpStatusCode.Ok) {
                            // feito isso para carregar tudo no app.vue, pois sem dar reload o app não carregava a sidebar
                            window.location.reload()
                        } else {
                            this.showMessage(
                                MessageEnum.alertTypeError(),
                                'Campo "Algo deu errado ao efetuar seu login!',
                                'Ocorreu um erro!'
                            )
                        }
                }).catch((response) => {
                    if (response.response.status === HttpStatusCode.Unauthorized) {
                        this.showMessage(
                            MessageEnum.alertTypeError(),
                            'Campo "Login ou senha incorreto!',
                            'Ocorreu um erro!'
                        )
                    }
                })
            },
            populateDate() {
                return {
                    email: this.user.email,
                    password: this.user.password
                }
            },
            async checkUserIsLogged() {
                await routerNonAuthenticated.login.isUserLogged().then((response) => {
                    if (response.data.isLogged) {
                        this.$router.push({name: 'dashboard'})
                    }
                })
            },
            showMessage(type, message, title) {
                this.$refs.message.showAlert(type, message, title)
            }
        },
        mounted() {
            localStorage.removeItem('mfp_token')
            localStorage.removeItem('userId')
            this.checkUserIsLogged()
        }
    }
</script>

<style scoped>
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
        box-shadow: 0 0 0.5em #000000;
    }
    .base-container hr {
        height: 8px;
        border: 0;
        border-radius: 15px 15px 15px 15px;
        box-shadow: 0 0 0.5em #000000;
        background-color: #04fac9;
    }
    .input-group-text {
        border: 0;
        background-color: #a7d7cf;
    }
    .text-button-login {
        font-size: 20px;
    }
</style>