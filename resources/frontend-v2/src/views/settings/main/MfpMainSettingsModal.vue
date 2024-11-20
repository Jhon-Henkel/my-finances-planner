<script setup lang="ts">
import MfpModalHeader from "@/modules/@shared/components/modal/MfpModalHeader.vue"
import MfpInputMoney from "@/modules/@shared/components/input/MfpInputMoney.vue"
import {ref} from "vue"
import {modalController, IonContent, IonList, IonNote} from "@ionic/vue"
import {onMounted} from "vue"
import {useMainSettingsStore} from "@/stores/settings/MainSettingsStore"
import {MainSettingsService} from "@/services/Settings/MainSettingsService"
import {MainSettingsModel} from "@/model/settings/MainSettingsModel"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"

const store = useMainSettingsStore()
const marketPlannerConfig = ref(0)

async function save() {
    const item = [
        new MainSettingsModel({
            name: 'market_planner_value',
            value: marketPlannerConfig.value
        })
    ]
    closeModal()
    await MainSettingsService.update(item)
    const toast = new MfpToast()
    await toast.open('Configurações salvas com sucesso!')
    store.load()
}

function closeModal() {
    modalController.dismiss()
}

onMounted(async () => {
    if (! store.isLoaded) {
        await store.load()
    }
    marketPlannerConfig.value = parseFloat(String(store.getSettingByName('market_planner_value')?.value))
})
</script>

<template>
    <mfp-modal-header title="Config. Gerais" @close-action="closeModal" @save-action="save"/>
    <ion-content>
        <ion-list :inset="true">
            <mfp-input-money v-model="marketPlannerConfig" label="Plano para Mercado"/>
        </ion-list>
        <ion-note color="medium" class="ion-margin-horizontal">
            Definindo um valor para o planejamento de mercado, será criado um plano de gastos com esse valor e o saldo
            será atualizado automaticamente conforme você for inserindo movimentações com o nome "Mercado".
        </ion-note>
    </ion-content>
</template>

<style scoped>
ion-note {
    display: block;
}
</style>
