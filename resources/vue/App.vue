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
                isLoggedUser: false
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
                    this.$router.push({name: 'login'})
                })
            }
        },
        mounted() {
            this.checkUserIsLogged()
        },
    }
</script>