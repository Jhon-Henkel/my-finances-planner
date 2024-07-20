<script setup lang="ts">
import {IonIcon, IonPage, IonRouterOutlet, IonTabBar, IonTabButton, IonTabs} from '@ionic/vue'
import {MfpModal} from "@/components/modal/MfpModal"
import MfpMenuAddModal from "@/views/menu/MfpMenuAddModal.vue"
import MfpMenuAllModal from "@/views/menu/MfpMenuAllModal.vue"
import {addOutline, calendarNumberOutline, homeOutline, menuOutline, swapHorizontalOutline} from "ionicons/icons"

const menuModal = new MfpModal(MfpMenuAllModal, true)

// todo - temporário até desenvolver tudo em ionic
function redirect(route: string) {
    window.location.href = route
}
</script>

<template>
    <ion-page>
        <ion-tabs>
            <ion-router-outlet/>
            <ion-tab-bar slot="bottom">
                <ion-tab-button tab="home" @click="redirect('/dashboard')">
                    <ion-icon :icon="homeOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="movements" href="/v2/movimentacoes">
                    <ion-icon :icon="swapHorizontalOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="add" id="mfp-tab-plus-modal">
                    <ion-icon :icon="addOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="settings" href="/v2/panorama">
                    <ion-icon :icon="calendarNumberOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="menu" @click="menuModal.open()">
                    <ion-icon :icon="menuOutline"/>
                </ion-tab-button>
            </ion-tab-bar>
        </ion-tabs>
        <mfp-menu-add-modal/>
    </ion-page>
</template>