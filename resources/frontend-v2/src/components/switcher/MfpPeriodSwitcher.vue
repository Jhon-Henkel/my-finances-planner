<script setup lang="ts">
import {IonButton, IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {chevronBackOutline, chevronForwardOutline} from "ionicons/icons"
import {UtilCalendar} from "@/util/UtilCalendar"
import {ref} from "vue"

const props = defineProps(
    {
        store: {
            type: Object,
            required: true
        }
    }
)

const store = props.store
const months = UtilCalendar.getNextSixMonths(UtilCalendar.getCurrentMonth())
const selectedMonth = ref(months[0])
store.installmentSelected = 1

function nextMonth() {
    let position = months.indexOf(selectedMonth.value)
    position ++
    if (position > months.length - 1) {
        position = 0
    }
    store.installmentSelected = position + 1
    selectedMonth.value = months[position]
}

function previousMonth() {
    let position = months.indexOf(selectedMonth.value)
    position --
    if (position < 0) {
        position = months.length - 1
    }
    store.installmentSelected = position + 1
    selectedMonth.value = months[position]
}
</script>

<template>
    <ion-item class="ion-text-center ion-margin-bottom ion-margin-top" lines="none">
        <ion-grid>
            <ion-row>
                <ion-col size="1" class="center-ion-label-content">
                    <ion-button @click="previousMonth" class="ion-padding-start">
                        <ion-icon :icon="chevronBackOutline"/>
                    </ion-button>
                </ion-col>
                <ion-col size="10" class="center-ion-label-content">
                    <ion-label>
                        <strong>{{ UtilCalendar.getMonthNameByNumber(selectedMonth) }}</strong>
                    </ion-label>
                </ion-col>
                <ion-col size="1" class="center-ion-label-content">
                    <ion-button @click="nextMonth" class="ion-margin-end">
                        <ion-icon :icon="chevronForwardOutline"/>
                    </ion-button>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
