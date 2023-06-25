<template>
    <div>
        <Doughnut :data="data" :options="options" />
    </div>
</template>

<script>
    import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
    import { Doughnut } from 'vue-chartjs'

    ChartJS.register(ArcElement, Tooltip, Legend)
    ChartJS.defaults.color = '#ffffff';

    export default {
        name: "DoughnutChart",
        components: {
            Doughnut
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
        },
    }
</script>