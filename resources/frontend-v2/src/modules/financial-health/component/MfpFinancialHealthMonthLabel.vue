<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"
import {useFinancialHealthStore} from "@/modules/financial-health/store/financialHealthStore"

const store = useFinancialHealthStore()
</script>

<template>
    <ion-item class="ion-text-center" lines="none">
        <ion-label>
            Resumo
            <strong>
                {{ UtilCalendar.getMonthNameByNumber(store.monthSelected) }}
            </strong>
        </ion-label>
    </ion-item>
</template>
