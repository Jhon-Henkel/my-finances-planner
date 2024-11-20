<script setup lang="ts">
import {IonAccordion, IonItem, IonLabel} from "@ionic/vue"

defineProps({
    title: {
        type: String,
        required: true
    },
    value: {
        type: String,
        required: true
    }
})
</script>

<template>
    <ion-accordion :value="value">
        <ion-item slot="header" color="light">
            <ion-label>{{ title }}</ion-label>
        </ion-item>
        <div class="ion-padding" slot="content">
            <slot/>
        </div>
    </ion-accordion>
</template>

<style scoped>

ion-accordion {
    margin: 0 auto;
}

ion-accordion.accordion-expanding,
ion-accordion.accordion-expanded {
    width: calc(100% - 32px);

    margin: 16px auto;
}

ion-accordion.accordion-collapsing ion-item[slot='header'],
ion-accordion.accordion-collapsed ion-item[slot='header'] {
    --background: var(--ion-color-light);
    --color: var(--ion-color-light-contrast);
}

ion-accordion.accordion-expanding ion-item[slot='header'],
ion-accordion.accordion-expanded ion-item[slot='header'] {
    --background: var(--ion-color-primary);
    --color: var(--ion-color-primary-contrast);
}
</style>