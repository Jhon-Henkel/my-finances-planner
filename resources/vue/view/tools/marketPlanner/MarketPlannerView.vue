<template>
    <div class="base-container">
        <div class="nav mt-2 justify-content-end">
            <mfp-title title="Planejamento para mercado"/>
            <back-button to="/ferramentas"/>
        </div>
        <divider/>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <div class="text-center">
                <font-awesome-icon icon="exclamation-triangle" class="me-2"/>
                <strong>Atenção!</strong>
            </div>
            <ul>
                <li>Assim que você salvar um valor no campo "", iremos gerar um planejamento para você.</li>
                <li>Em panorama irá aparecer um registro com esse planejamento.</li>
                <li>No mês atual irá levar em consideração as movimentações já feitas com o nome "Mercado".</li>
                <li>Portanto, sempre que gastar algo no mercado salve a movimentação com a descrição "Mercado".</li>
            </ul>
        </div>
        <form class="was-validated">
            <input-money :value="marketValuePlanner" @input-money="marketValuePlanner = $event" title="Valor Planejado"/>
        </form>
        <divider/>
        <bottom-buttons redirect-to="/ferramentas" button-success-text="Salvar" @btn-clicked="save"/>
    </div>
</template>

<script>
import Divider from '~vue-component/DividerComponent.vue'
import BackButton from '~vue-component/buttons/BackButton.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import InputMoney from '~vue-component/inputMoneyComponent.vue'
import BottomButtons from '~vue-component/BottomButtons.vue'

export default {
    name: 'MarketPlannerView',
    components: {
        BottomButtons,
        InputMoney,
        Divider,
        BackButton,
        MfpTitle
    },
    data() {
        return {
            marketValuePlanner: 0,
        }
    },
    methods: {
        save() {
            console.log('Desenvolver Salvar dados')
        },
        getValuePlanner() {
            console.log('Desenvolver pegar configuração do planejamento')
        }
    },
    mounted() {
        this.getValuePlanner()
    }
}
</script>