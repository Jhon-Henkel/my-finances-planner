<script setup lang="ts">
import {IonIcon, IonPage, IonRouterOutlet, IonTabBar, IonTabButton, IonTabs} from '@ionic/vue'
import {MfpModal} from "@/components/modal/MfpModal"
import MfpMenuAddModal from "@/views/menu/MfpMenuAddModal.vue"
import MfpMenuAllModal from "@/views/menu/MfpMenuAllModal.vue"
import {addOutline, calendarNumberOutline, homeOutline, menuOutline, swapHorizontalOutline} from "ionicons/icons"
import router from "@/router"

const menuModal = new MfpModal(MfpMenuAllModal, true)
</script>

<template>
    <ion-page>
        <ion-tabs>
            <ion-router-outlet/>
            <ion-tab-bar slot="bottom">
                <ion-tab-button tab="home" @click="router.push({name: 'dashboard'})">
                    <ion-icon :icon="homeOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="movements" @click="router.push({name: 'movements'})">
                    <ion-icon :icon="swapHorizontalOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="add" id="mfp-tab-plus-modal">
                    <ion-icon :icon="addOutline"/>
                </ion-tab-button>
                <ion-tab-button tab="settings" @click="router.push({name: 'panorama'})">
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