<template>
    <div>
        <line :data="data" :options="options" />
    </div>
</template>

<script>
    import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
    import {Line} from "vue-chartjs";

    ChartJS.register(ArcElement, Tooltip, Legend)
    ChartJS.defaults.color = '#ffffff';

    export default {
        name: "LineChart",
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
        },
    }
</script>