<script setup lang="ts">
import {IonIcon, IonPage, IonRouterOutlet, IonTabBar, IonTabButton, IonTabs} from '@ionic/vue'
import {MfpModal} from "@/modules/@shared/components/modal/MfpModal"
import MfpMenuAddModal from "@/modules/menu/MfpMenuAddModal.vue"
import MfpMenuAllModal from "@/modules/menu/MfpMenuAllModal.vue"
import {addOutline, calendarNumberOutline, homeOutline, menuOutline, swapHorizontalOutline} from "ionicons/icons"
import router from "../../infra/router"
import {ref} from "vue"
import {RouteName} from "@/infra/router/routeName"

const menuModal = new MfpModal(MfpMenuAllModal, true)
const dashboardSelected = ref(true)
const movementsSelected = ref(false)
const panoramaSelected = ref(false)

function goToRoute(route: string) {
    if (route === 'dashboard') {
        dashboardSelected.value = true
        movementsSelected.value = false
        panoramaSelected.value = false
        router.push({name: route})
    } else if (route === 'movements') {
        dashboardSelected.value = false
        movementsSelected.value = true
        panoramaSelected.value = false
        router.push({name: route})
    } else if (route === RouteName.spending_plan) {
        dashboardSelected.value = false
        movementsSelected.value = false
        panoramaSelected.value = true
        router.push({name: route})
    } else if (route === 'menu') {
        dashboardSelected.value = false
        movementsSelected.value = false
        panoramaSelected.value = false
        menuModal.open()
    }
}

</script>

<template>
    <ion-page>
        <ion-tabs>
            <ion-router-outlet/>
            <ion-tab-bar slot="bottom">
                <ion-tab-button @click="goToRoute('dashboard')" :selected="dashboardSelected">
                    <ion-icon :icon="homeOutline"/>
                </ion-tab-button>
                <ion-tab-button @click="goToRoute('movements')" :selected="movementsSelected">
                    <ion-icon :icon="swapHorizontalOutline"/>
                </ion-tab-button>
                <ion-tab-button id="mfp-tab-plus-modal">
                    <ion-icon :icon="addOutline"/>
                </ion-tab-button>
                <ion-tab-button @click="goToRoute(RouteName.spending_plan)" :selected="panoramaSelected">
                    <ion-icon :icon="calendarNumberOutline"/>
                </ion-tab-button>
                <ion-tab-button @click="goToRoute('menu')">
                    <ion-icon :icon="menuOutline"/>
                </ion-tab-button>
            </ion-tab-bar>
        </ion-tabs>
        <mfp-menu-add-modal/>
    </ion-page>
</template>
