<template>
    <div class="base-container">
        <div class="card text-center login-box glass">
            <h3 class="title">Login</h3>
            <div class="card-body">
                <hr v-show="messageLogin">
                <message :message="messageLogin" :type="messageLoginType" v-show="messageLogin"/>
                <form class="form-horizontal" @submit="login">
                    <hr>
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
                    <hr>
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
    import Message from "../../components/MessageComponent.vue";
    import messageEnum from "../../../js/enums/messageEnum";

    export default {
        name: "LoginView",
        components: {
            Message
        },
        data() {
            return {
                user: {},
                messageLogin: null,
                messageLoginType: null
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
                            this.$router.push({name: 'dashboard'})
                        } else {
                            this.messageLogin = 'Algo deu errado ao efetuar seu login!'
                            this.messageLoginType = messageEnum.messageTypeError()
                        }
                }).catch((response) => {
                    if (response.response.status === HttpStatusCode.Unauthorized) {
                        this.messageLogin = 'Login ou senha incorreto!'
                        this.messageLoginType = messageEnum.messageTypeError()
                    }
                })
            },
            populateDate() {
                return {
                    email: this.user.email,
                    // todo essa senha tem que ser criptografada no front e descriptografada no backend
                    password: this.user.password
                }
            }
        },
        mounted() {
            this.messageLogin = null
            this.messageLoginType = null
        }
    }
</script>

<style scoped>
    .card-body {
        padding: 0;
        margin: 0 20px 25px 20px;
    }
    .title {
        margin-top: 20px;
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