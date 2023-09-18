<template>
    <Line :data="data" :options="options" />
</template>

<script>
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js'
import { Line } from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend)
ChartJS.defaults.color = '#ffffff'

export default {
    name: 'LineChart',
    components: {
        Line
    },
    props: {
        data: {
            type: Object,
            required: true
        },
        options: {
            type: Object,
            required: true
        }
    }
}
</script>