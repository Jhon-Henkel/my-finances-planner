<template>
    <div class="offcanvas offcanvas-start glass" data-bs-scroll="true" tabindex="-1" id="sidebar"
         aria-labelledby="sidebar"
         data-bs-backdrop="false">
        <div class="offcanvas-header">
            <h4 class="offcanvas-title" id="sidebar">
                My finances planner
            </h4>
            <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="offcanvas"
                    aria-label="Close"/>
        </div>
        <div class="offcanvas-body">
            <h6 class="text-center mt-3">
                {{ salutation }}
            </h6>
            <nav class="nav flex-column ms-4 mt-5">
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Dashboard">
                    <i class="fa-solid fa-chart-line me-2"></i>
                    Dashboard
                </router-link>
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Movimentações">
                    <i class="fa-solid fa-money-bill-transfer me-2"></i>
                    Movimentações
                </router-link>
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Panorama">
                    <i class="fa-solid fa-money-bill-trend-up me-2"></i>
                    Panorama
                </router-link>
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Ganhos Futuros">
                    <i class="fa-solid fa-money-bill-wave me-2"></i>
                    Ganhos Futuros
                </router-link>
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Carteiras">
                    <i class="fa-solid fa-wallet me-2"></i>
                    Carteiras
                </router-link>
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Gerenciar Cartões">
                    <i class="fa-solid fa-credit-card me-2"></i>
                    Gerenciar Cartões
                </router-link>
                <router-link class="nav-link sidebar-item a-default"
                   aria-current="page"
                   to="#"
                   title="Despesas Cartões">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                    Despesas Cartões
                </router-link>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SideBarComponent",
        data() {
            return {
                salutation: localStorage.getItem('salutation')
            }
        }
    }
</script>

<style scoped>

</style>