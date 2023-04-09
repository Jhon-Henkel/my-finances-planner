<template>
    <nav>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <router-link class="nav-link a-default" data-bs-toggle="offcanvas" to="" title="Menu"
                             data-bs-target="#sidebar"
                             aria-controls="sidebar">
                    <i class="fa-solid fa-bars"></i>
                </router-link>
            </li>
            <li class="nav-item">
                <!-- todo criar rota e tela para configurações -->
                <router-link class="nav-link a-default" aria-current="page" to="#" title="Configurações">
                    <i class="fa-solid fa-gear"></i>
                </router-link>
            </li>
            <li class="nav-item">
                <a class="nav-link a-default" aria-current="page" href="#" title="Logout" @click.prevent="logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "NavBarComponent",
        methods: {
            logout() {
                axios.get('/logout').then(response => {
                    localStorage.removeItem('salutation')
                    this.$router.go('/login');
                })
            }
        }
    }
</script>

<style scoped>

</style>