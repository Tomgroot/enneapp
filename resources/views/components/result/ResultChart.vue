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
    },
    data() {
        return {
            chartData: {
                labels: ['1', '2', '3', '4', '5', '6', '7', '8', '9'],
                datasets: [
                    {
                        data: Object.values(this.percentages),
                        label: '',
                        backgroundColor: '#2f9a6e',
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
                    },
                },
            },
        };
    },
});
</script>
