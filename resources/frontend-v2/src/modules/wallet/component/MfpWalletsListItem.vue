<script setup lang="ts">
import {IonCol, IonGrid, IonIcon, IonItem, IonLabel, IonRow} from "@ionic/vue"
import {WalletModel} from "@/modules/wallet/model/WalletModel"
import {UtilMoney} from "@/modules/@shared/util/UtilMoney"
import {chevronBackOutline} from "ionicons/icons"

defineProps(
    {
        wallet: {
            type: WalletModel,
            required: true
        }
    }
)
</script>

<template>
    <ion-item>
        <ion-grid>
            <ion-row class="ion-row">
                <ion-col>
                    <ion-row>
                        <ion-col size="6">
                            <ion-label class="text-truncate">
                                <strong>
                                    {{ wallet.name }}
                                </strong>
                            </ion-label>
                        </ion-col>
                        <ion-col size="5">
                            <ion-label>
                                {{ UtilMoney.formatValueToBr(wallet.amount) }}
                            </ion-label>
                        </ion-col>
                        <ion-col size="1" class="ion-text-end no-padding-end">
                            <ion-icon :icon="chevronBackOutline" class="animate-icon-left" />
                        </ion-col>
                    </ion-row>
                </ion-col>
            </ion-row>
        </ion-grid>
    </ion-item>
</template>
