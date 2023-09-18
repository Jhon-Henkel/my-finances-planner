<template>
    <div>
        <bar :options="graphOptions" :data="chartData"/>
    </div>
</template>

<script>
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'
import { Bar } from 'vue-chartjs'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)
ChartJS.defaults.color = '#ffffff'

export default {
    name: 'BarChart',
    components: {
        Bar
    },
    props: {
        chartData: {
            type: Object,
            required: true
        },
        graphOptions: {
            type: Object,
            required: true
        }
    }
}
</script>