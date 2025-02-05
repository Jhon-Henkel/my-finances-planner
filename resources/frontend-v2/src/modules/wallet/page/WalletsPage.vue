<script setup lang="ts">
import {
    IonButton,
    IonIcon,
    IonItemOption,
    IonItemOptions,
    IonItemSliding,
    IonLabel,
    IonList,
    IonListHeader
} from "@ionic/vue"
import {pencilOutline, trashOutline} from "ionicons/icons"
import MfpRefresh from "@/modules/@shared/components/refresh/MfpRefresh.vue"
import MfpPage from "@/modules/@shared/components/page/MfpPage.vue"
import {onMounted, ref} from "vue"
import MfpCirclePlusButton from "@/modules/@shared/components/button/MfpCirclePlusButton.vue"
import MfpEmptyListItem from "@/modules/@shared/components/list/MfpEmptyListItem.vue"
import MfpWalletsBalanceCard from "@/modules/wallet/component/MfpWalletsBalanceCard.vue"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpWalletsFormModal from "@/modules/wallet/component/MfpWalletsFormModal.vue"
import MfpWalletsListItem from "@/modules/wallet/component/MfpWalletsListItem.vue"
import MfpWalletsListSkeletonLoad from "@/modules/wallet/component/MfpWalletsListSkeletonLoad.vue"
import {MfpToast} from "@/modules/@shared/components/toast/MfpToast"
import {WalletModel} from "@/modules/wallet/model/WalletModel"
import {MfpConfirmAlert} from "@/modules/@shared/components/alert/MfpConfirmAlert"
import {WalletService} from "@/modules/wallet/service/WalletService"
import {useWalletStore} from "@/modules/wallet/store/WalletStore"
import MfpTotalRegistersRow from "@/modules/@shared/components/page/MfpTotalRegistersRow.vue"

const walletStore = useWalletStore()
const formModal = new MfpModal(MfpWalletsFormModal)
const onlyWithFounds = ref(false)

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

function mustShowItem(item: WalletModel, onlyWithFounds: boolean): boolean {
    return ! onlyWithFounds || (onlyWithFounds && item.amount !== 0)
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
        <mfp-wallets-balance-card :store="walletStore"/>
        <div class="ion-text-end">
            <ion-button fill="clear" @click="onlyWithFounds = !onlyWithFounds">
                {{ onlyWithFounds ? 'Ver Todas' : 'Ver somente com saldo' }}
            </ion-button>
        </div>
        <mfp-empty-list-item :nothing-to-show="walletStore.wallets.length === 0 && walletStore.isLoaded"/>
        <mfp-wallets-list-skeleton-load :is-loaded="walletStore.isLoaded"/>
        <ion-list v-if="walletStore.isLoaded && walletStore.notHiddenWallets.length > 0">
            <ion-list-header>
                <ion-label>Visíveis</ion-label>
            </ion-list-header>
            <ion-item-sliding
                v-for="wallet in walletStore.notHiddenWallets"
                :key="wallet.id"
                class="ion-text-center"
                v-show="mustShowItem(wallet, onlyWithFounds)"
            >
                <mfp-wallets-list-item :wallet="wallet"/>
                <ion-item-options side="end">
                    <ion-item-option color="primary" @click="formModal.open({wallet: wallet})">
                        <ion-icon slot="top" :icon="pencilOutline"/>
                        Editar
                    </ion-item-option>
                    <ion-item-option color="danger" @click="deleteWallet(wallet)">
                        <ion-icon slot="top" :icon="trashOutline"/>
                        Deletar
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <ion-list v-if="walletStore.isLoaded && walletStore.hiddenWallets.length > 0">
            <ion-list-header>
                <ion-label>Ocultas</ion-label>
            </ion-list-header>
            <ion-item-sliding
                v-for="wallet in walletStore.hiddenWallets"
                :key="wallet.id"
                class="ion-text-center"
                v-show="mustShowItem(wallet, onlyWithFounds)"
            >
                <mfp-wallets-list-item :wallet="wallet"/>
                <ion-item-options side="end">
                    <ion-item-option color="primary" @click="formModal.open({wallet: wallet})">
                        <ion-icon slot="top" :icon="pencilOutline"/>
                        Editar
                    </ion-item-option>
                    <ion-item-option color="danger" @click="deleteWallet(wallet)">
                        <ion-icon slot="top" :icon="trashOutline"/>
                        Deletar
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <ion-list v-if="walletStore.isLoaded && walletStore.inactiveWallets.length > 0">
            <ion-list-header>
                <ion-label>Inativas</ion-label>
            </ion-list-header>
            <ion-item-sliding
                v-for="wallet in walletStore.inactiveWallets"
                :key="wallet.id"
                class="ion-text-center"
                v-show="mustShowItem(wallet, onlyWithFounds)"
            >
                <mfp-wallets-list-item :wallet="wallet"/>
                <ion-item-options side="end">
                    <ion-item-option color="primary" @click="formModal.open({wallet: wallet})">
                        <ion-icon slot="top" :icon="pencilOutline"/>
                        Editar
                    </ion-item-option>
                    <ion-item-option color="danger" @click="deleteWallet(wallet)">
                        <ion-icon slot="top" :icon="trashOutline"/>
                        Deletar
                    </ion-item-option>
                </ion-item-options>
            </ion-item-sliding>
        </ion-list>
        <mfp-total-registers-row :total-itens="walletStore.wallets.length"/>
    </mfp-page>
</template>
