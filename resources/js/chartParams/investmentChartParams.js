import StringTools from '../tools/stringTools'

const investmentChartParams = {
    options: {
        animation: {
            y: {
                easing: 'easeInQuad',
                duration: 3000,
                from: -100
            }
        },
        scales: {
            x: {
                stacked: true,
                grid: {
                    display: false
                }
            },
            y: {
                stacked: true,
                grid: {
                    display: false
                },
                ticks: {
                    display: false
                }
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Total por tipo'
            },
            legend: {
                display: true,
                position: 'bottom'
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
                    }
                }
            }
        }
    },
    data: {
        labels: [],
        datasets: [
            {
                label: 'CDB',
                backgroundColor: '#7ee057',
                data: [0]
            }
        ]
    }
}

export default investmentChartParams