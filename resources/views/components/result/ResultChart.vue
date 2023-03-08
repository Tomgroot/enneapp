<template>
    <Bar
        id="my-chart-id"
        ref="bar"
        :options="chartOptions"
        :chart-options="chartOptions"
        :style="chartOptions"
        :data="chartData"
    />
</template>

<script>
import { Bar } from 'vue-chartjs';
import {
    Chart as ChartJS,
    BarElement,
    CategoryScale,
    LinearScale,
} from 'chart.js';

ChartJS.register(BarElement, CategoryScale, LinearScale);

import { defineComponent } from 'vue';

export default defineComponent({
    components: { Bar },
    props: {
        percentages: {
            type: Object,
        },
        ordered: {
            type: Array,
        },
    },
    data() {
        return {
            chartData: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
                datasets: [
                    {
                        data: Object.values(this.percentages),
                        label: '',
                        backgroundColor: new Array(9)
                            .fill('rgba(47, 154, 110, 0.5)')
                            .fill(
                                'rgb(47, 154, 110)',
                                this.ordered[0] - 1,
                                this.ordered[0]
                            )
                            .fill(
                                'rgb(47, 154, 110)',
                                this.ordered[1] - 1,
                                this.ordered[1]
                            )
                            .fill(
                                'rgb(47, 154, 110)',
                                this.ordered[2] - 1,
                                this.ordered[2]
                            ),
                    },
                ],
            },
            chartOptions: {
                borderWidth: 0,
                fill: false,
                legend: '',
                scales: {
                    y: {
                        display: false,
                        grid: {
                            display: false,
                        },
                    },
                    x: {
                        grid: {
                            display: false,
                        },
                        border: {
                            color: 'rgba(236, 137, 69, 0.2)',
                        },
                        ticks: {
                            color: '#563118',
                            showLabelBackdrop: false,
                        },
                    },
                },
            },
        };
    },
});
</script>
