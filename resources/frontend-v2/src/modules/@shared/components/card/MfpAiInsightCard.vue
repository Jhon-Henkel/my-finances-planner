<script setup lang="ts">
import {AiInsightDto} from "@/modules/@shared/dto/ai/AiInsightModel"
import {chatboxOutline, informationCircleOutline} from "ionicons/icons"
import {IonCard, IonCardSubtitle, IonCol, IonIcon, IonRow, IonText} from "@ionic/vue"
import {PropType} from "vue"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import {UtilCalendar} from "@/modules/@shared/util/UtilCalendar"

const props = defineProps({
    insight: {
        type: Object as PropType<AiInsightDto>,
        required: true
    }
})

function info() {
    const alert = new MfpOkAlert('Dica da IA')
    alert.open(
        `Essa dica foi gerada em ${UtilCalendar.formatStringToBr(props.insight.created_at)}, uma nova dica será gerada em ${props.insight.life_time_days} dias.`
    )
}
</script>

<template>
    <ion-row>
        <ion-col>
            <ion-card class="ion-no-margin" color="light">
                <ion-row class="ion-margin center-ion-label-content">
                    <ion-col size="2">
                        <ion-icon :icon="chatboxOutline" size="large" color="warning"/>
                    </ion-col>
                    <ion-col size="10">
                        <ion-card-subtitle class="center-vertical-ion-label-content">
                            Dica da IA
                            <ion-icon
                                :icon="informationCircleOutline"
                                size="small"
                                color="primary"
                                class="icon-start"
                                @click="info"
                            />
                        </ion-card-subtitle>
                        <ion-text>
                            {{ insight.insight }}
                        </ion-text>
                    </ion-col>
                </ion-row>
            </ion-card>
        </ion-col>
    </ion-row>
</template>
