<script setup lang="ts">
import {
    IonIcon,
    IonItemOption,
    IonItemOptions,
    IonItemSliding,
    IonLabel,
    IonList,
    IonListHeader
} from "@ionic/vue"
import {ellipsisHorizontal} from "ionicons/icons"
import MfpRefresh from "@/components/refresh/MfpRefresh.vue"
import MfpPage from "@/components/page/MfpPage.vue"
import {onMounted} from "vue"
import MfpCirclePlusButton from "@/components/button/MfpCirclePlusButton.vue"
import MfpEmptyListItem from "@/components/list/MfpEmptyListItem.vue"
import MfpWalletsBalanceCard from "@/views/wallets/MfpWalletsBalanceCard.vue"
import {MfpModal} from "@/components/modal/MfpModal"
import MfpWalletsFormModal from "@/views/wallets/MfpWalletsFormModal.vue"
import MfpWalletsListItem from "@/views/wallets/MfpWalletsListItem.vue"
import MfpWalletsListSkeletonLoad from "@/views/wallets/MfpWalletsListSkeletonLoad.vue"
import {MfpToast} from "@/components/toast/MfpToast"
import {WalletModel} from "@/model/wallet/WalletModel"
import {MfpActionSheet} from "@/components/action-sheet/MfpActionSheet"
import {UtilActionSheet} from "@/util/UtilActionSheet"
import {MfpConfirmAlert} from "@/components/alert/MfpConfirmAlert"
import {WalletService} from "@/services/wallet/WalletService"
import {useWalletStore} from "@/stores/wallet/WalletStore"
import MfpTotalRegistersRow from "@/components/page/MfpTotalRegistersRow.vue"

const walletStore = useWalletStore()
const formModal = new MfpModal(MfpWalletsFormModal)

async function optionsAction(wallet: WalletModel) {
    const actionSheet = new MfpActionSheet(UtilActionSheet.makeButtons(true, true, true))
    const action = await actionSheet.open()
    if (action === 'edit') {
        await formModal.open({wallet: wallet})
    } else if (action === 'delete') {
        await deleteWallet(wallet)
    }
}

async function deleteWallet(wallet: WalletModel) {
    const deleteConfirmAlert = new MfpConfirmAlert('Deseja realmente deletar a carteira?')
    const confirmDelete = await deleteConfirmAlert.open(`Deseja realmente excluir a carteira ${wallet.name}?`)
    if (confirmDelete) {
        await WalletService.delete(wallet.id)
        const toast = new MfpToast()
        await toast.open('Carteira deletada com sucesso!')
        await WalletService.forceUpdateWalletList()
    }
}

async function handleRefresh(event: any) {
    await WalletService.forceUpdateWalletList()
    event.target.complete()
}

onMounted(async () => {
    await WalletService.updateWalletList()
})
</script>

<template>
    <mfp-page>
        <mfp-refresh @refresh-content="handleRefresh($event)"/>
        <ion-list-header>
            <ion-label>Carteiras</ion-label>
            <mfp-circle-plus-button @click="formModal.open()"/>
        </ion-list-header>
        <mfp-wallets-balance-card :balance="walletStore.getTotalAmount"/>
        <mfp-empty-list-item :nothing-to-show="walletStore.wallets.length === 0 && walletStore.isLoaded"/>
        <mfp-wallets-list-skeleton-load :is-loaded="walletStore.isLoaded"/>
        <ion-list v-if="walletStore.isLoaded">
            <ion-item-sliding v-for="wallet in walletStore.wallets" :key="wallet.id" class="ion-text-center">
                <mfp-wallets-list-item :wallet="wallet"/>
                <ion-item-options side="end">
                    <ion-item-option color="light" expandable @click="optionsAction(wallet)">
                        <ion-icon slot="top" :icon="ellipsisHorizontal"/>
                        Opções
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="walletStore.wallets.length"/>
    </mfp-page>
</template>