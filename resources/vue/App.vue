<template>
    <div>
        <side-bar-component/>
        <div v-show="isDemoMode" class="mt-5">
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                <font-awesome-icon icon="exclamation-triangle" class="me-2"/>
                <strong>Atenção!</strong>
                <br>
                Você está utilizando o sistema em modo demonstração, algumas funcionalidades podem estar desabilitadas.
                <br>
                Para mais detalhes clique <a href="/sobre">aqui</a>.
            </div>
        </div>
        <router-view/>
    </div>
</template>

<script>
import SideBarComponent from './components/SideBarComponent.vue'
import RequestTools from '../js/tools/requestTools'

export default {
    name: 'App',
    components: {
        SideBarComponent
    },
    data() {
        return {
            isDemoMode: false
        }
    },
    async mounted() {
        this.isDemoMode = RequestTools.isApplicationInDemoMode()
    }
}
</script>