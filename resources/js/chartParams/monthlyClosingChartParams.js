import StringTools from "../tools/stringTools";

export const monthlyClosingChartParams = {
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    color: '#464646'
                }
            },
            y: {
                grid: {
                    color: '#464646'
                },
                ticks: {
                    callback: function(value, index, values) {
                        return StringTools.formatFloatValueToBrString(value)
                    }
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || ''
                        if (label) {
                            label += ': '
                        }
                        if (context.parsed.y !== null) {
                            label += StringTools.formatFloatValueToBrString(context.parsed.y)
                        }
                        return label
                    },
                }
            },
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