<script setup lang="ts">
import router from "../../infra/router"
import {IonButton, IonButtons, IonHeader, IonIcon, IonItem, IonTitle, IonToolbar, modalController} from "@ionic/vue"
import MfpModalContent from "@/modules/@shared/components/modal/MfpModalContent.vue"
import {AuthService} from "@/modules/login/service/AuthService"
import {MenuItems} from "@/modules/menu/MenuItems"
import {logOutOutline} from "ionicons/icons"
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpUserSettingsModal from "@/modules/setings/modal/user/MfpUserSettingsModal.vue"
import MfpMainSettingsModal from "@/modules/setings/modal/main/MfpMainSettingsModal.vue"

function goToRoute(routeName: string) {
    if (routeName === 'login') {
        AuthService.logout()
        router.push({ name: 'login' }).then(() => {
            window.location.reload();
        });
    }
    modalController.dismiss()
    if (routeName === 'user-settings') {
        const userSettingsModal = new MfpModal(MfpUserSettingsModal)
        closeMenu()
        userSettingsModal.open()
        return
    } else if (routeName === 'main-settings') {
        const mainSettingsModal = new MfpModal(MfpMainSettingsModal)
        closeMenu()
        mainSettingsModal.open()
        return
    }
    router.push({name: routeName})
}

function closeMenu() {
    modalController.dismiss()
}
</script>

<template>
    <ion-header>
        <ion-toolbar>
            <ion-buttons slot="start">
                <ion-button @click="closeMenu">
                    Fechar
                </ion-button>
            </ion-buttons>
            <ion-title>Menu</ion-title>
            <ion-buttons slot="end">
                <ion-button @click="goToRoute('login')">
                    <ion-icon :icon="logOutOutline" color="danger"/>
                </ion-button>
            </ion-buttons>
        </ion-toolbar>
    </ion-header>
    <MfpModalContent>
        <template #list>
            <ion-item v-for="(item, index) in MenuItems" :key="index" button @click="goToRoute(item.routeName)">
                <ion-icon :icon="item.icon" slot="start"/>
                {{ item.label }}
            </ion-item>
        </template>
    </MfpModalContent>
</template>
