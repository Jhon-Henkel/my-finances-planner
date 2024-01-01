import { describe, it, expect } from 'vitest'
import dashboardChartParams from '~js/chartParams/dashboardChartParams'
import StringTools from "~js/tools/stringTools";

describe('Test dashboardChartParams file', () => {
    it('options', function () {
        let chartOptions = dashboardChartParams.options
        let expectedOptions = {
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
                    text: 'Movimentações por mês (Últimos 12 meses)'
                },
                legend: {
                    display: true,
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
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
        }
        expect(chartOptions.animation.y.easing).toEqual(expectedOptions.animation.y.easing)
        expect(chartOptions.animation.y.duration).toEqual(expectedOptions.animation.y.duration)
        expect(chartOptions.animation.y.from).toEqual(expectedOptions.animation.y.from)
        expect(chartOptions.scales.x.stacked).toEqual(expectedOptions.scales.x.stacked)
        expect(chartOptions.scales.x.grid.display).toEqual(expectedOptions.scales.x.grid.display)
        expect(chartOptions.scales.y.stacked).toEqual(expectedOptions.scales.y.stacked)
        expect(chartOptions.scales.y.grid.display).toEqual(expectedOptions.scales.y.grid.display)
        expect(chartOptions.scales.y.ticks.display).toEqual(expectedOptions.scales.y.ticks.display)
        expect(chartOptions.plugins.title.display).toEqual(expectedOptions.plugins.title.display)
        expect(chartOptions.plugins.title.text).toEqual(expectedOptions.plugins.title.text)
        expect(chartOptions.plugins.legend.display).toEqual(expectedOptions.plugins.legend.display)
        expect(chartOptions.plugins.legend.position).toEqual(expectedOptions.plugins.legend.position)
    })

    it('data', function () {
        let chartData = dashboardChartParams.data
        let expectedData = {
            labels: [],
            datasets: [
                {
                    label: 'Balanço',
                    backgroundColor: '#e0c857',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                },
                {
                    label: 'Gastos',
                    backgroundColor: '#f87979',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                },
                {
                    label: 'Ganhos',
                    backgroundColor: '#79f879',
                    data: [0,0,0,0,0,0,0,0,0,0,0,0]
                }
            ]
        }
        expect(chartData.labels).toEqual(expectedData.labels)
        expect(chartData.datasets[0].label).toEqual(expectedData.datasets[0].label)
        expect(chartData.datasets[0].backgroundColor).toEqual(expectedData.datasets[0].backgroundColor)
        expect(chartData.datasets[0].data).toEqual(expectedData.datasets[0].data)
        expect(chartData.datasets[1].label).toEqual(expectedData.datasets[1].label)
        expect(chartData.datasets[1].backgroundColor).toEqual(expectedData.datasets[1].backgroundColor)
        expect(chartData.datasets[1].data).toEqual(expectedData.datasets[1].data)
    })
})