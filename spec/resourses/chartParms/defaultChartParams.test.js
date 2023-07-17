import { describe, it, expect } from 'vitest'
import defaultChartParams from '../../../resources/js/chartParams/defaultChartParams'

describe('Test defaultChartParams file', () => {
    it('options', function () {
        let chartOptions = defaultChartParams.options('bottom')
        let expectedOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        }
        expect(chartOptions.responsive).toEqual(expectedOptions.responsive)
        expect(chartOptions.maintainAspectRatio).toEqual(expectedOptions.maintainAspectRatio)
        expect(chartOptions.plugins.legend.display).toEqual(expectedOptions.plugins.legend.display)
        expect(chartOptions.plugins.legend.position).toEqual(expectedOptions.plugins.legend.position)
    })

    it('data', function () {
        let chartData = defaultChartParams.data
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