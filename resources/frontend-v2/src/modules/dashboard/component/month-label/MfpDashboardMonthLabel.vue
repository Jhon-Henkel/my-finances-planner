<script setup lang="ts">
import {IonItem, IonLabel} from "@ionic/vue"
import {UtilCalendar} from "@/util/UtilCalendar"
</script>

<template>
    <ion-item class="ion-text-center" lines="none">
        <ion-label>
            Resumo
            <strong>
                {{ UtilCalendar.getMonthNameByNumber(UtilCalendar.getCurrentMonth()) }}
            </strong>
        </ion-label>
    </ion-item>
</template>