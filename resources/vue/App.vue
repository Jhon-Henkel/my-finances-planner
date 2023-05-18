<template>
    <div>
        <side-bar-component v-show="isLoggedUser"/>
        <div v-show="isDemoMode" class="mt-5">
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                <font-awesome-icon icon="exclamation-triangle" class="me-2"/>
                <strong>Atenção!</strong>
                <br>
                Você está utilizando a aplicação em modo demonstração, algumas funcionalidades podem estar desabilitadas.
                Para mais detalhes clique <a href="/sobre">aqui</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" />
            </div>
        </div>
        <router-view/>
    </div>
</template>

<script>
    import SideBarComponent from "./components/SideBarComponent.vue";
    import routerNonAuthenticated from "../js/router/routerNonAuthenticated";
    import requestTools from "../js/tools/requestTools";

    export default {
        name: 'App',
        components: {
            SideBarComponent
        },
        data() {
            return {
                isLoggedUser: false,
                isLogged: false,
                isDemoMode: false
            }
        },
        methods: {
            async checkUserIsLogged() {
                await routerNonAuthenticated.login.isUserLogged().then((response) => {
                    if (response.data.isLogged) {
                        this.isLoggedUser = true
                        return
                    }
                    this.isLoggedUser = false
                    if (this.$route.name === 'about') {
                        return
                    }
                    this.$router.push({name: 'login'})
                })
            }
        },
        async mounted() {
            await this.checkUserIsLogged()
            this.isDemoMode = requestTools.isApplicationInDemoMode()
        },
    }
</script>