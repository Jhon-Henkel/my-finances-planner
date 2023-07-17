import { describe, it, expect } from 'vitest'
import { monthlyClosingChartParams } from '../../../resources/js/chartParams/monthlyClosingChartParams'

describe('Test monthlyClosingChartParams file', () => {
    it('options', function () {
        let chartOptions = monthlyClosingChartParams.options
        let expectedOptions = {
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
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
        expect(chartOptions.responsive).toEqual(expectedOptions.responsive)
        expect(chartOptions.maintainAspectRatio).toEqual(expectedOptions.maintainAspectRatio)
        expect(chartOptions.scales.x.grid.color).toEqual(expectedOptions.scales.x.grid.color)
        expect(chartOptions.scales.y.grid.color).toEqual(expectedOptions.scales.y.grid.color)
        expect(chartOptions.plugins.legend.display).toEqual(expectedOptions.plugins.legend.display)
        expect(chartOptions.plugins.legend.position).toEqual(expectedOptions.plugins.legend.position)
    })

    it('data', function () {
        let chartData = monthlyClosingChartParams.data
        let expectedData = {
            labels: [],
            datasets: [
                {
                    backgroundColor: [],
                    data: []
                }
            ]
        }
        expect(chartData.labels).toEqual(expectedData.labels)
        expect(chartData.datasets[0].backgroundColor).toEqual(expectedData.datasets[0].backgroundColor)
        expect(chartData.datasets[0].data).toEqual(expectedData.datasets[0].data)
    })
})