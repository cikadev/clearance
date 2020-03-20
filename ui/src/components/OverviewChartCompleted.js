import { Pie } from 'vue-chartjs'

export default {
    extends: Pie,
    data: () => ({
        chartdata: {
            labels: ['Done', 'Undone'],
            datasets: [
                {
                    label: 'Data One',
                    backgroundColor: '#f87979',
                    data: [60, 40]
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    }),

    mounted () {
        this.renderChart(this.chartdata, this.options)
    }
}
