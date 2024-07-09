<script setup lang="ts">
import Vue3Autocounter from "vue3-autocounter"

defineProps(
    {
        start: {
            type: Number,
            required: false,
            default: 0
        },
        end: {
            type: Number,
            required: true
        },
        duration: {
            type: Number,
            required: false,
            default: 1
        }
    }
)

</script>

<template>
    <vue3-autocounter
        :startAmount='start'
        :endAmount='end'
        :duration='duration'
        prefix='R$ '
        separator='.'
        decimalSeparator=','
        :decimals='2'
        :autoinit='true'
    />
</template>