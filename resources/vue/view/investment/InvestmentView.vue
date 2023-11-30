<template>
    <div class="base-container">
        <mfp-message :message-data="messageData"/>
        <loading-component v-show="loadingDone === false"/>
        <div v-show="loadingDone">
            <div class="nav mt-2 justify-content-end">
                <mfp-title title="Investimentos"/>
                <!-- Temporário -->
                <div style="display: none">
                    <mfp-drop-down-button :buttons-array="buttons" />
                </div>
            </div>
            <divider/>
               <div>Em Desenvolvendo...</div>
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
import IconEnum from "~js/enums/iconEnum";

export default {
    name: 'InvestmentView',
    components: {
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
                    title: 'Novo Investimento',
                    icon: IconEnum.billTrendUp(),
                    redirectTo: '/investimentos/cadastrar'
                }
            ]
        }
    }
}
</script>