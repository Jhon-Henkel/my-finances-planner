<template>
    <div class="sidebar glass" :class="isOpened ? 'open' : ''" v-if="mustShow">
        <div class="sidebar-header">
            <div class="salutation">
                {{ salutation }}
            </div>
            <i class="bx" :class="isOpened ? 'bx-x me-3' : 'bx-menu'" id="btn" @click="isOpened = !isOpened"/>
        </div>
        <hr>
        <div class="sidebar-container">
            <div id="sidebar-nav">
                <ul class="nav-list">
                    <li v-for="(item, index) in menuItens" :key="index" :id="'tooltip_' + index">
                        <router-link class="a-default" :to="item.to" @click="isOpened = false">
                            <i :class="item.icon"/>
                            <span class="tooltip_name">{{ item.name }}</span>
                            {{ item.title }}
                        </router-link>
                        <span :data-target="'tooltip_' + index" class="tooltip">
                            {{ item.title }}
                        </span>
                    </li>
                </ul>
            </div>
            <div class="sidebar-footer">
                <span class="developed-by">
                    Desenvolvido por
                    <a href="https://www.jhon.dev.br" target="_blank" class="portfolio-link">Jhonatan Henkel</a>
                </span>
                <i class="bx bx-log-out" id="log-out" @click="logout" title="Logout"/>
            </div>
        </div>
    </div>
</template>

<script>
import apiRouter from '../../js/router/apiRouter'
import { userAuthStore } from '../store/auth'

export default {
    name: 'SideBarComponent',
    data() {
        return {
            mustShow: false,
            isOpened: false,
            isMenuOpen: false,
            isUsedVueRouter: false,
            isPaddingLeft: true,
            salutation: '',
            // Icons: https://github.com/atisawd/boxicons/tree/master/svg
            menuItens: [
                {
                    title: 'Dashboard',
                    icon: 'bx bxs-pie-chart-alt-2 me-2',
                    to: '/dashboard'
                },
                {
                    title: 'Panorama',
                    icon: 'bx bxs-compass me-2',
                    to: '/panorama'
                },
                {
                    title: 'Movimentações',
                    icon: 'bx bxs-coin-stack me-2',
                    to: '/movimentacoes'
                },
                {
                    title: 'Ganhos Futuros',
                    icon: 'bx bxs-dollar-circle me-2',
                    to: '/ganhos-futuros'
                },
                {
                    title: 'Investimentos',
                    icon: 'bx bxs-chart me-2',
                    to: '/investimentos'
                },
                {
                    title: 'Carteiras',
                    icon: 'bx bxs-wallet me-2',
                    to: '/carteiras'
                },
                {
                    title: 'Gerenciar Cartões',
                    icon: 'bx bxs-credit-card me-2',
                    to: '/gerenciar-cartoes'
                },
                {
                    title: 'Ferramentas',
                    icon: 'bx bxs-wrench me-2',
                    to: '/ferramentas'
                },
                {
                    title: 'Configurações',
                    icon: 'bx bxs-cog me-2',
                    to: '/configuracoes'
                }
            ]
        }
    },
    methods: {
        logout() {
            apiRouter.userActions.logout().then(() => {
                this.$router.go('/login')
            })
        },
        tooltipAttached() {
            const tooltips = document.querySelectorAll('.tooltip')
            tooltips.forEach(tooltip => {
                document.body.appendChild(tooltip)
            })
            document.querySelectorAll('.tooltip').forEach(tooltip => {
                const targetID = tooltip.dataset.target
                const target = document.querySelector(`#${targetID}`)
                if (!target) return
                target.addEventListener('mouseenter', () => {
                    const targetPosition = target.getBoundingClientRect()
                    if (this.isOpened) return
                    tooltip.style.top = `${targetPosition.top + window.scrollY}px`
                    tooltip.style.left = `${targetPosition.left + targetPosition.width + 20}px`
                    tooltip.classList.add('active')
                })
                target.addEventListener('mouseleave', () => {
                    tooltip.classList.remove('active')
                })
            })
        },
        mustShowSidebar() {
            const { name } = this.$route
            const routesMustNotShow = ['login', 'about']
            return !routesMustNotShow.includes(name)
        }
    },
    watch: {
        isOpened() {
            window.document.body.style.paddingLeft = this.isOpened && this.isPaddingLeft ? '230px' : '0px'
            this.salutation = userAuthStore().user?.salutation
        },
        '$route'() {
            this.mustShow = this.mustShowSidebar()
        }
    },
    mounted() {
        this.tooltipAttached()
        this.mustShowSidebar()
    }
}
</script>

<style scoped>
    @import '../../font/poppins.css';
    @import url('https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css');
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }
    .sidebar {
        display: flex;
        background: #11101d;
        flex-direction: column;
        position: fixed;
        left: 0;
        top: 1px;
        height: 100%;
        min-height: min-content;
        width: 78px;
        z-index: 99;
        transition: all 0.5s ease;
        white-space: nowrap;
        border-radius: 0 15px 15px 0;
    }
    .sidebar.open {
        width: 300px;
    }
    .sidebar .sidebar-header {
        height: 60px;
        display: flex;
        align-items: center;
        position: relative;
        margin: 6px 14px 0 14px;
    }
    .sidebar-container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        flex-grow: 1;
        max-height: calc(100% - 60px);
    }
    .sidebar .sidebar-header .salutation {
        color: #fff;
        font-size: 20px;
        font-weight: 600;
        opacity: 0;
        transition: all 0.2s ease;
    }
    .sidebar.open .sidebar-header .salutation {
        opacity: 1;
        transition: all 1s ease !important;
    }
    .sidebar .sidebar-header #btn {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        font-size: 23px;
        text-align: center;
        cursor: pointer;
        transition: all 0.5s ease;
    }
    .sidebar.open .sidebar-header #btn {
        text-align: right;
    }
    .sidebar i {
        color: #fff;
        height: 60px;
        min-width: 50px;
        font-size: 28px;
        text-align: center;
        line-height: 60px;
    }
    .sidebar .nav-list {
        margin-top: 20px;
        overflow: visible;
    }
    .sidebar li {
        position: relative;
        margin: 8px 0;
        list-style: none;
    }
    .sidebar input {
        font-size: 15px;
        color: #fff;
        font-weight: 400;
        outline: none;
        height: 50px;
        width: 100%;
        border: none;
        border-radius: 12px;
        transition: all 0.5s ease;
        background: #1d1b31;
    }
    .sidebar.open input {
        padding: 0 20px 0 50px;
        width: 100%;
    }
    .sidebar li a {
        display: flex;
        height: 100%;
        width: 100%;
        border-radius: 12px;
        align-items: center;
        text-decoration: none;
        transition: all 0.4s ease;
        background: #11101d;
    }
    .sidebar li a:hover {
        background: #096452;
        color: #ffffff;
        box-shadow: 0 0.5em 0.5em -0.4em #000000;
        transform: translateY(-0.25em);
        transition-duration: 300ms;
    }
    .router-link-exact-active {
        background: #096452 !important;
        color: #ffffff !important;
        box-shadow: 0 0.5em 0.5em -0.4em #000000 !important;
    }
    .sidebar li router-link {
        display: flex;
        height: 100%;
        width: 100%;
        border-radius: 12px;
        align-items: center;
        text-decoration: none;
        transition: all 0.5s ease;
        background: #11101d;
    }
    .sidebar li router-link:hover {
        background: #fff;
    }
    .sidebar li i {
        height: 50px;
        line-height: 50px;
        font-size: 18px;
        border-radius: 12px;
    }
    .sidebar div.sidebar-footer {
        position: relative;
        height: 60px;
        width: 78px;
        padding: 10px 14px;
        background: #1d1b31;
        transition: all 0.5s ease;
        overflow: hidden;
    }
    .sidebar.open div.sidebar-footer {
        width: 300px;
    }
    .sidebar .sidebar-footer #log-out {
        position: absolute;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        background: #1d1b31;
        width: 100%;
        height: 60px;
        line-height: 60px;
        transition: all 0.5s ease;
    }
    .sidebar.open .sidebar-footer #log-out {
        width: 50px;
        background: #1d1b31;
        opacity: 1;
    }
    .sidebar.open .sidebar-footer:hover #log-out {
        opacity: 1;
    }
    .sidebar.open .sidebar-footer #log-out:hover {
        opacity: 1;
        color: red;
        cursor: pointer;
    }
    .sidebar .sidebar-footer #log-out:hover,
    .sidebar.open .sidebar-header i:hover {
        color: red;
        cursor: pointer;
    }
    #sidebar-nav {
        overflow-y: auto;
        height: calc(100% - 60px);
        margin: 6px 14px 0 14px;
    }
    #sidebar-nav::-webkit-scrollbar {
        display: none;
    }
    .tooltip {
        position: absolute;
        z-index: 3;
        background: #000;
        color: #fff;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 15px;
        font-weight: 400;
        opacity: 0;
        white-space: nowrap;
        pointer-events: none;
        transition: 0s;
    }
    .tooltip.active {
        opacity: 1;
        pointer-events: auto;
        transition: all 0.4s ease;
        transform: translateY(25%);
    }
    .sidebar.open li .tooltip {
        display: none;
    }
    .sidebar hr {
        width: 80%;
        height: 8px;
        border: 0;
        border-radius: 0 15px 15px 0;
        background-color: #04fac9;
    }
    .developed-by {
        font-size: 13px;
        float: left;
        top: 25%;
        position: relative;
    }
    .portfolio-link {
        color: #04fac9;
        text-decoration: none;
    }
    @media (max-width: 1000px) {
        .sidebar li .tooltip {
            display: none;
        }
        .sidebar.glass {
            background-color: transparent;
            box-shadow: none;
            border-radius: 0;
            backdrop-filter: none;
            -webkit-backdrop-filter: none;
        }
        .sidebar.open {
            width: 100%;
            height: 100%;
            background: #11101d;
            border-radius: 0;
        }
        .sidebar.open hr {
            width: 80%;
            height: 8px;
            border: 0;
            border-radius: 0 15px 15px 0;
            background-color: #04fac9;
        }
        .sidebar {
            height: 50px;
            width: 65px;
            background: transparent;
            border-radius: 0 0 15px 0;
        }
        .sidebar hr {
            display: none;
        }
        .sidebar div.sidebar-footer {
            display: none;
        }
        .sidebar.open div.sidebar-footer {
            display: flex;
            width: 100%;
        }
        .bx-menu {
            color: #04fac9 !important;
        }

    }
</style>