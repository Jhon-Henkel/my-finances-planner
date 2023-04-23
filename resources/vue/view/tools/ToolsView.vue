<template>
    <div class="base-container">
        <loading-component v-show="loadingDone === false" @loading-done="loadingDone = true"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <h3 id="title">Ferramentas</h3>
            </div>
            <hr class="mb-4">
            <h5 class="mb-4">
                Ferramentas que auxiliam nas suas finanças pessoais, para que você não precise se preocupar em fazer contas...
            </h5>
            <hr class="mb-4">
            <div class="card me-5" v-for="(item, index) in items" :key="index">
                <img :src="item.imagePath" class="card-img-top" height="200">
                <div class="card-body">
                    <h5 class="card-title">{{ item.title }}</h5>
                    <p class="card-text">{{ item.description }}</p>
                    <a :href="item.redirectTo" class="btn btn-success rounded-5 btn-full">
                        <font-awesome-icon :icon="iconEnum.wrench()" class="me-2"/>
                        Usar
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {FontAwesomeIcon} from "@fortawesome/vue-fontawesome";
    import iconEnum from "../../../js/enums/iconEnum";
    import LoadingComponent from "../../components/LoadingComponent.vue";

    export default {
        name: "ToolsView",
        computed: {
            iconEnum() {
                return iconEnum
            }
        },
        components: {LoadingComponent, FontAwesomeIcon},
        data() {
            return {
                loadingDone: false,
                items: [
                    {
                        title: 'Calcular Salário',
                        imagePath: '../../../../public/images/tools/wage.png',
                        description: 'Faça o cálculo de seu salário conforme os dias trabalhados.',
                        redirectTo: '/ferramentas/calculadora-salario'
                    },
                    {
                        title: 'Calcular Horas Extras',
                        imagePath: '../../../../public/images/tools/extra-hour.jpg',
                        description: 'Faça o cálculo de quanto você vai receber em horas extras.',
                        redirectTo: '/ferramentas/calculadora-horas-extras'
                    },
                ]
            }
        }
    }
</script>

<style scoped>
    .card {
        width: 18rem;
        border-radius: 15px;
        box-shadow: 0 0 1em #000000;
        background-color: #2a2a38;
        color: #ffffff;
        display: inline-flex;
    }
</style>