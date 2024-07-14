<script setup lang="ts">
import MfpPage from "@/components/page/MfpPage.vue"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import {IonIcon, IonItemOption, IonItemOptions, IonItemSliding, IonLabel, IonList, IonListHeader} from "@ionic/vue"
import MfpPanoramaPeriodSwitcher from "@/views/panorama/MfpPanoramaPeriodSwitcher.vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"
import MfpPanoramaDetailsCard from "@/views/panorama/MfpPanoramaDetailsCard.vue"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import MfpTotalRegistersRow from "@/components/page/MfpTotalRegistersRow.vue"
import {ellipsisHorizontal} from "ionicons/icons"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import MfpPanoramaListItem from "@/views/panorama/MfpPanoramaListItem.vue"
import {InvoiceModel} from "@/model/invoice/invoiceModel"
import {onMounted} from "vue"
import {usePanoramaStore} from "@/stores/panorama/PanoramaStore"
import MfpPanoramaListSkeletonLoad from "@/views/panorama/MfpPanoramaListSkeletonLoad.vue"
import {PanoramaService} from "@/services/panorama/PanoramaService"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpPanoramaFormModal from "@/views/panorama/MfpPanoramaFormModal.vue"

const store = usePanoramaStore()
const formModal = new MfpModal(MfpPanoramaFormModal)

async function optionsAction(item: InvoiceModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtonsToPanorama())
    const action = await actionSheet.open()
    console.log(action, item)
}

async function handleRefresh(event: any) {
    await PanoramaService.forceReloadStore()
    event.target.complete()
}

onMounted(async () => {
    if (!store.isLoaded) {
        await store.load()
    }
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Plano de Gastos</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-panorama-period-switcher/>
        <mfp-panorama-details-card/>
        <mfp-empty-list-item :nothing-to-show="store.panorama.futureExpenses.length === 0 && store.isLoaded"/>
        <mfp-panorama-list-skeleton-load :is-loaded="store.isLoaded"/>
        <ion-list v-if="store.isLoaded">
            <ion-item-sliding v-for="(item, index) in store.panorama.futureExpenses" :key="index">
                <mfp-panorama-list-item :panoramaItem="item"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" @click="optionsAction(item)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="store.panorama.futureExpenses.length"/>
    </mfp-page>
</template>
