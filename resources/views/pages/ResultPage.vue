<template>
    <div class="result container">
        <TestHeader title="Resultaat" subtitle="Waarschijnlijk ben je..." />
        <ResultType
            :title="getTypeTitle(winner)"
            :subtitle="getTypeDescription(winner)"
            :keywords="getTypeKeywords(winner)"
            :picture="getTypePicture(winner)"
            read-more="https://www.identiteitsystemen.nl/enneagram/"
        />
        <ResultPossible
            description="Het kan ook nog dat je één van deze enneagramtypes bent:"
            :types="getPossibleTypes()"
            :get-type-title="getTypeTitle"
            :get-type-description="getTypeDescription"
            :get-type-percentage="getTypePercentage"
            :get-type-keywords="getTypeKeywords"
            read-more="https://www.identiteitsystemen.nl/enneagram/"
        />
        <ResultChart
            :percentages="chartData"
            :ordered="results.ordered"
            class="result__chart"
        />
        <ResultPossible
            description="Waar je het minste voor hebt gescoord:"
            :types="getMostUnlikely()"
            :get-type-title="getTypeTitle"
            :get-type-percentage="getTypePercentage"
            :get-type-description="getTypeDescription"
            :get-type-keywords="getTypeKeywords"
            read-more="https://www.identiteitsystemen.nl/enneagram/"
        />
    </div>
</template>
<style lang="scss" scoped>
.result {
    &__chart {
        margin-top: 2rem;
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestHeader from '../components/test/TestHeader.vue';
import ResultType from '../components/result/ResultType.vue';
import ResultPossible from '../components/result/ResultPossible.vue';
import ResultChart from '../components/result/ResultChart.vue';

export default defineComponent({
    components: {
        ResultChart,
        ResultType,
        ResultPossible,
        TestHeader,
    },
    props: {
        results: {
            type: Object,
        },
        winner: {
            type: String,
            default: '0',
        },
    },
    data() {
        return {
            ordered: {
                types: [] as number[],
            },
            chartData: [] as number[],
        };
    },
    created() {
        if (this.results) {
            for (let i = 1; i <= 9; i++) {
                this.chartData.push(this.results.percentages.total[i]);
            }
        }
    },
    methods: {
        getTypeTitle(type: string) {
            return type;
        },
        getTypePercentage(type: string) {
            if (this.results) {
                return `(${Math.round(
                    this.results.percentages.total[parseInt(type)]
                )}%)`;
            }
            return '';
        },
        getTypePicture(type: string) {
            return `assets/Enneagramtype-${type}.jpg`;
        },
        getTypeDescription(type: string) {
            if (type == '1') {
                return 'Hun beweegreden is autonomie behouden door het juiste te doen en het goed te doen. Ze doen er alles aan om fouten te voorkomen.';
            } else if (type == '2') {
                return 'Hun beweegreden is liefde ontvangen door te voorzien in de behoeften van anderen die voor hen belangrijk zijn.';
            } else if (type == '3') {
                return 'De beweegreden is aandacht te krijgen door te presteren en succesvol te zijn.';
            } else if (type == '4') {
                return 'Beweegreden is geliefd worden door bijzonder zijn. In een unieke liefde verbonden willen zijn met een ander, omdat ze de verbinding met zichzelf zijn verloren en willen herstellen.';
            } else if (type == '5') {
                return 'De beweegreden is bescherming tegen inmenging door anderen door zich emotioneel terug te trekken.';
            } else if (type == '6') {
                return 'Hun beweegreden is veiligheid creëren door waakzaamheid, zaken in twijfel trekken en op zaken vooruitlopen.';
            } else if (type == '7') {
                return 'Beweegreden is het vermijden van angst en pijn door het verbeelden en opzoeken van plezierige mogelijkheden.';
            } else if (type == '8') {
                return 'Hun beweegreden is respect krijgen door sterk en confronterend te zijn en kwetsbaarheid te verbergen.';
            } else if (type == '9') {
                return 'Beweegreden is acceptatie door zichzelf te vergeten. Door zelf niets nodig te hebben, veroorzaken ze geen reden om afgewezen worden.';
            }
        },
        getTypeKeywords(type: string) {
            if (type == '1') {
                return 'Perfectionisten, hervormers, verbeteraars';
            } else if (type == '2') {
                return 'De helpers, de gevers, verzorgers';
            } else if (type == '3') {
                return 'De performers, succeszoekers, harde werkers';
            } else if (type == '4') {
                return 'De romantici, artiesten, individualisten';
            } else if (type == '5') {
                return 'De analisten, onderzoekers, observeerders';
            } else if (type == '6') {
                return 'De loyalisten, sceptici, rebellen';
            } else if (type == '7') {
                return 'De levensgenieters, optimisten, charmeurs';
            } else if (type == '8') {
                return 'De bazen, leiders, beschermers';
            } else if (type == '9') {
                return 'De bemiddelaars, vredestichters, vredebewaarders';
            }
        },
        getPossibleTypes(): string[] {
            if (this.results) {
                return [this.results.ordered[1], this.results.ordered[2]];
            }
            return [];
        },
        getMostUnlikely(): number[] {
            if (this.results) {
                return [this.results.ordered[8], this.results.ordered[7]];
            }
            return [];
        },
    },
});
</script>
