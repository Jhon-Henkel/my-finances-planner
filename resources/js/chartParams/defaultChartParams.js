import StringTools from '../tools/stringTools'

const defaultChartParams = {
    options(legendPosition) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: legendPosition
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || ''
                            if (label) {
                                label += ': '
                            }
                            if (context.parsed !== null) {
                                label += StringTools.formatFloatValueToBrString(context.parsed)
                            }
                            return label
                        }
                    }
                }
            }
        }
    },
    data: {
        labels: [],
        datasets: [
            {
                backgroundColor: [],
                data: []
            }
        ]
    }
}

export default defaultChartParams