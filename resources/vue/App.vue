<template>
    <div>
        <side-bar-component v-show="isLoggedUser"/>
        <router-view/>
    </div>
</template>

<script>
    import SideBarComponent from "./components/SideBarComponent.vue";
    import routerNonAuthenticated from "../js/router/routerNonAuthenticated";

    export default {
        name: 'App',
        components: {
            SideBarComponent
        },
        data() {
            return {
                isLoggedUser: false,
                isLogged: false,
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
        },
    }
</script>