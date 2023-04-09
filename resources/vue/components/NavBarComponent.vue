<template>
    <nav>
        <ul class="nav justify-content-end">
            <li class="nav-item">
                <router-link class="nav-link a-default" data-bs-toggle="offcanvas" to="" title="Menu" data-bs-target="#sidebar"
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
                <router-link class="nav-link a-default" aria-current="page" to="/logout" title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </router-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "NavBarComponent"
    }
</script>

<style scoped>

</style>