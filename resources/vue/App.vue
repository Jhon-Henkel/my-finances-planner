<template>
    <div>
        <side-bar-component/>
        <div v-show="isDemoMode" class="mt-5">
            <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                <font-awesome-icon icon="exclamation-triangle" class="me-2"/>
                <strong>Atenção!</strong>
                <br>
                Você está utilizando a aplicação em modo demonstração, algumas funcionalidades podem estar desabilitadas.
                <br>
                Este projeto não foi desenvolvido para mobile, tenha preferência por utilizar em um computador.
                Para mais detalhes clique <a href="/sobre">aqui</a>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" />
            </div>
        </div>
        <router-view/>
    </div>
</template>

<script>
    import SideBarComponent from "./components/SideBarComponent.vue";
    import RequestTools from "../js/tools/requestTools";

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