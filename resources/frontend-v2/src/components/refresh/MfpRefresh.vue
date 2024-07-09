<script setup lang="ts">
/**
 * O componente ion-refresher do Ionic Framework deve ser usado como um filho direto de ion-content. Isso ocorre porque
 * ion-refresher precisa de um rolagem de conteúdo para funcionar corretamente, o ion-content fornece esse contexto de
 * rolagem. Se você tentar usar ion-refresher fora de um ion-content, ele não funcionará como esperado.
 */
import {IonRefresherContent, IonRefresher} from "@ionic/vue"
import {refreshOutline} from "ionicons/icons"

const emits = defineEmits(['refresh-content'])

function handleRefresh(event: any) {
    emits('refresh-content', event)
}
</script>

<template>
    <ion-refresher slot="fixed" @ionRefresh="handleRefresh($event)">
        <ion-refresher-content :pulling-icon="refreshOutline" pulling-text="Puxe para atualizar..." />
    </ion-refresher>
</template>