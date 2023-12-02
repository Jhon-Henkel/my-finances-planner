import { describe, it, expect } from 'vitest'
import StringTools from '~js/tools/stringTools'
import investmentChartParams from '~js/chartParams/investmentChartParams'

describe('Test investmentChartParams.test file', () => {
    it('options', function () {
        let chartOptions = investmentChartParams.options
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
        let chartData = investmentChartParams.data
        let expectedData = {
            labels: [],
            datasets: [
                {
                    label: 'CDB',
                    backgroundColor: '#7ee057',
                    data: [0]
                }
            ]
        }
        expect(chartData.labels).toEqual(expectedData.labels)
        expect(chartData.datasets[0].label).toEqual(expectedData.datasets[0].label)
        expect(chartData.datasets[0].backgroundColor).toEqual(expectedData.datasets[0].backgroundColor)
        expect(chartData.datasets[0].data).toEqual(expectedData.datasets[0].data)
    })
})