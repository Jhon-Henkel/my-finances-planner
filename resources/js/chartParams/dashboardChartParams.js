import StringTools from '../tools/stringTools'

const dashboardChartParams = {
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
                text: 'Movimentações por mês (Últimos 6 meses + este mês)'
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
                label: 'Balanço',
                backgroundColor: '#e0c857',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
            {
                label: 'Gastos',
                backgroundColor: '#f87979',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            },
            {
                label: 'Ganhos',
                backgroundColor: '#79f879',
                data: [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0]
            }
        ]
    }
}

export default dashboardChartParams