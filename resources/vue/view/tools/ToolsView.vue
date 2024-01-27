<template>
    <div class="base-container">
        <div class="nav mt-2 justify-content-end">
            <mfp-title :title="'Ferramentas'"/>
        </div>
        <divider/>
        <h5 class="mb-4">
            Ferramentas que auxiliam nas suas finanças pessoais, para que você não precise se preocupar
            em fazer planilhas...
        </h5>
        <divider/>
        <div class="text-center ms-4">
            <div class="card me-4 mt-4" v-for="(item, index) in items" :key="index">
                <img :src="item.imagePath" class="card-img-top image-card" height="200">
                <div class="card-body">
                    <h5 class="card-title">{{ item.title }}</h5>
                    <p class="card-text">{{ item.description }}</p>
                    <a :href="item.redirectTo" class="btn btn-success rounded-2 btn-full">
                        <font-awesome-icon :icon="iconEnum.wrench()" class="me-2"/>
                        Usar
                    </a>
                </div>
            </div>
        </div>
    </div>
    <divider/>
</template>

<script>
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import iconEnum from '../../../js/enums/iconEnum'
import Divider from '../../components/DividerComponent.vue'
import MfpTitle from '../../components/TitleComponent.vue'

export default {
    name: 'ToolsView',
    computed: {
        iconEnum() {
            return iconEnum
        }
    },
    components: { MfpTitle, Divider, FontAwesomeIcon },
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
                {
                    title: 'Saúde Financeira',
                    imagePath: '../../../../public/images/tools/financial-health.jpg',
                    description: 'Relatório que separa as movimentações por tipo.',
                    redirectTo: '/ferramentas/saude-financeira'
                },
                {
                    title: 'Fechamento de Mês',
                    imagePath: '../../../../public/images/tools/monthly-closing.jpg',
                    description: 'Relatório que mostra o fechamento do mês.',
                    redirectTo: '/ferramentas/fechamento-mensal'
                },
                {
                    title: 'Planejamento Mercado',
                    imagePath: '../../../../public/images/tools/market.png',
                    description: 'Planeje de gastos mensais para o mercado.',
                    redirectTo: '/ferramentas/planejamento-mercado'
                }
            ]
        }
    }
}
</script>

<style lang="scss" scoped>
    @import "../../../sass/variables";

    .card {
        width: 18rem;
        border-radius: 15px;
        box-shadow: 0 0 1em $black-color;
        background-color: $default-card-background-color;
        color: $white-color;
        display: inline-flex;
    }
    .image-card {
        border-radius: 15px 15px 0 0;
    }
</style>