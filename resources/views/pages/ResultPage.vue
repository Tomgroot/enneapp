<template>
    <div class="result">
        <TestHeader
            title="Resultaat"
            subtitle="Waarschijnlijk ben je een type..."
        />
        <ResultType
            :title="getTypeTitle(winner)"
            :subtitle="getTypeDescription(winner)"
            read-more="https://www.identiteitsystemen.nl/enneagram/"
        />
        <ResultPossible
            description="Het kan ook nog dat je één van deze enneagramtypes bent:"
            v-if="results && results.winners && results.winners.length > 1"
            :types="getPossibleTypes()"
            :get-type-title="getTypeTitle"
            :get-type-description="getTypeDescription"
            :get-type-percentage="getTypePercentage"
            read-more="https://www.identiteitsystemen.nl/enneagram/"
        />
        <ResultPossible
            description="Waar je het minste voor hebt gescoord"
            :types="getMostUnlikely()"
            :get-type-title="getTypeTitle"
            :get-type-percentage="getTypePercentage"
            :get-type-description="getTypeDescription"
            read-more="https://www.identiteitsystemen.nl/enneagram/"
        />
    </div>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestHeader from '../components/test/TestHeader.vue';
import ResultType from '../components/result/ResultType.vue';
import ResultPossible from '../components/result/ResultPossible.vue';

export default defineComponent({
    components: {
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
            percentages: {
                scales: [] as number[],
                keywords: [] as number[],
                summaries: [] as number[],
                total: [] as number[],
            },
        };
    },
    created() {
        console.log(this.results);
    },
    methods: {
        getTypeTitle(type: string) {
            return `Enneagramtype ${type}`;
        },
        getTypePercentage(type: string) {
            return `(${Math.round(this.percentages.total[parseInt(type)])}%)`;
        },
        getTypeDescription(type: string) {
            if (type == '1') {
                return 'Perfectionisten, hervormers, verbeteraars - Hun beweegreden is autonomie behouden door het juiste te doen en het goed te doen. Ze doen er alles aan om fouten te voorkomen.\n';
            } else if (type == '2') {
                return 'De helpers, de gevers, verzorgers - Hun beweegreden is liefde ontvangen door te voorzien in de behoeften van anderen die voor hen belangrijk zijn.';
            } else if (type == '3') {
                return 'De performers, succeszoekers, harde werkers - De beweegreden is aandacht te krijgen door te presteren en succesvol te zijn.';
            } else if (type == '4') {
                return 'De romantici, artiesten, individualisten - Beweegreden is geliefd worden door bijzonder zijn. In een unieke liefde verbonden willen zijn met een ander, omdat ze de verbinding met zichzelf zijn verloren en willen herstellen.';
            } else if (type == '5') {
                return 'De analisten, onderzoekers, observeerders - De beweegreden is bescherming tegen inmenging door anderen door zich emotioneel terug te trekken.';
            } else if (type == '6') {
                return 'De loyalisten, sceptici, rebellen - Hun beweegreden is veiligheid creëren door waakzaamheid, zaken in twijfel trekken en op zaken vooruitlopen.';
            } else if (type == '7') {
                return 'De levensgenieters, optimisten, charmeurs - Beweegreden is het vermijden van angst en pijn door het verbeelden en opzoeken van plezierige mogelijkheden.';
            } else if (type == '8') {
                return 'De bazen, leiders, beschermers - Hun beweegreden is respect krijgen door sterk en confronterend te zijn en kwetsbaarheid te verbergen.';
            } else if (type == '9') {
                return 'De bemiddelaars, vredestichters, vredebewaarders - Beweegreden is acceptatie door zichzelf te vergeten. Door zelf niets nodig te hebben, veroorzaken ze geen reden om afgewezen worden.';
            }
        },
        getPossibleTypes(): string[] {
            const types = [] as string[];
            if (this.results && this.results.winners) {
                this.results.winners.forEach((winner: string) => {
                    if (winner != this.winner) {
                        types.push(winner);
                    }
                });
            }
            return types;
        },
        getMostUnlikely(): number[] {
            let lowest = 1000;
            let type = 0;
            this.percentages.total.forEach((value, i) => {
                if (value <= lowest) {
                    type = i;
                    lowest = value;
                }
            });
            return [type];
        },
    },
});
</script>
