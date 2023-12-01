<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Investimentos"/>
                <mfp-drop-down-button :buttons-array="buttons" />
            </div>
            <divider/>
                <h1>Desenvolvendo</h1>
            <divider/>
        </div>
    </div>
</template>

<script>
import MfpMessage from '~vue-component/MessageAlert.vue'
import LoadingComponent from '~vue-component/LoadingComponent.vue'
import MfpTitle from '~vue-component/TitleComponent.vue'
import MfpDropDownButton from '~vue-component/buttons/DropDownButtonGroup.vue'
import Divider from '~vue-component/DividerComponent.vue'
import IconEnum from '~js/enums/iconEnum'
import ActionButtons from '~vue-component/ActionButtons.vue'
import investmentEnum from '~js/enums/investmentEnum'

export default {
    name: 'InvestmentView',
    computed: {
        investmentEnum() {
            return investmentEnum
        }
    },
    components: {
        ActionButtons,
        Divider,
        MfpDropDownButton,
        MfpTitle,
        LoadingComponent,
        MfpMessage
    },
    data() {
        return {
            messageData: {},
            loadingDone: true,
            buttons: [
                {
                    title: 'Novo CDB',
                    icon: IconEnum.billTrendUp(),
                    redirectTo: '/investimentos/cdb/cadastrar'
                }
            ],
        }
    },
    methods: {

    },
    mounted() {

    }
}
</script>