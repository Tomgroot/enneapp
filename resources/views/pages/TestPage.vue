<template>
    <div class="container">
        <TestHeader :title="getTitle()" :subtitle="getSubtitle()" />
        <div class="content">
            <ScaleSection
                :scales="scales"
                :nr="nr"
                :current="getSection() === 'scales'"
                @next="(selection) => selectScale(selection)"
            />
            <KeywordSection
                :keywords="keywords"
                :nr="nr - this.scales.length"
                :current="getSection() === 'keywords'"
                :transition="transition"
                @next="(selection) => selectKeywords(selection)"
            />
            <SummarySection
                :summaries="summaries"
                :current="getSection() === 'summaries'"
                :transition="transition"
                :nr="nr - this.scales.length - this.keywords.length"
                @next="(selection, f) => selectSummaries(selection, f)"
            />
            <WinnerSection
                :winners="winners"
                :current="getSection() === 'winners'"
                :transition="transition"
                @next="(selection) => selectWinner(selection)"
            />
        </div>
        <ProgressBar
            @prev="prev"
            @next="next"
            :has-prev="this.nr > 0"
            :has-next="hasNext()"
            :progress="getProgress()"
        />
    </div>
</template>
<style lang="scss" scoped>
.content {
    flex: 1;
    display: flex;
    margin-bottom: 3rem;
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestHeader from '../components/test/TestHeader.vue';
import ProgressBar from '../components/test/TestProgressBar.vue';
import type {
    IOption,
    IQuestionData,
    ISelected,
    IScale,
    IDividedPoints,
    ISelectedPoints,
} from '../types';
import ScaleSection from '../components/ScaleSection.vue';
import KeywordSection from '../components/KeywordSection.vue';
import SummarySection from '../components/SummarySection.vue';
import WinnerSection from '../components/WinnerSection.vue';
import { calculateResults } from '../utils';

export default defineComponent({
    components: {
        SummarySection,
        KeywordSection,
        ScaleSection,
        WinnerSection,
        ProgressBar,
        TestHeader,
    },
    props: {
        questionDataRaw: {
            type: String,
            default: '',
        },
    },
    data() {
        return {
            selected: {
                scales: [] as ISelectedPoints[],
                keywords: [] as IDividedPoints[][],
                summaries: [] as IOption[],
            } as ISelected,
            scales: [] as IScale[],
            keywords: [] as IOption[][],
            summaries: [] as IOption[][],
            winners: [] as IOption[],
            nr: 0,
            transition: 'fade-swipe',
        };
    },
    methods: {
        selectScale(selected: ISelectedPoints[]): void {
            this.selected.scales = selected;
            this.transition = 'fade-swipe';
            this.next();
        },
        selectKeywords(selected: IDividedPoints[][]): void {
            this.selected.keywords = selected;
            this.transition = 'fade-swipe';
            console.log(this.selected.keywords, 'JO');
            this.next();
        },
        selectSummaries(selected: IOption[], finish = false): void {
            this.selected.summaries = selected;
            this.transition = 'fade-swipe';
            if (finish) {
                this.finish();
            } else {
                this.next();
            }
        },
        selectWinner(winner: IOption): void {
            this.finish(winner);
        },
        getSection(): string {
            if (this.nr < this.scales.length) {
                return 'scales';
            } else if (this.nr < this.scales.length + this.keywords.length) {
                return 'keywords';
            } else if (this.winners.length > 0) {
                return 'winners';
            } else {
                return 'summaries';
            }
        },
        next() {
            this.nr++;
        },
        finish(winner: IOption | undefined = undefined) {
            const results = calculateResults(this.selected);
            if (results.winners.length > 1 && !winner) {
                this.generateWinners(results.winners);
            } else {
                this.nr = 999;
                const win =
                    winner && winner.type ? winner.type : results.winners[0];
                this.$emit('results', results, win);
            }
        },
        prev() {
            this.transition = 'gone';
            if (this.nr > 0) {
                this.nr--;
            }
        },
        getProgress(): number {
            return Math.min(
                (this.nr /
                    (this.keywords.length +
                        this.summaries.length +
                        this.scales.length)) *
                    100,
                100
            );
        },
        hasNext(): boolean {
            return (
                this.selected.scales.length +
                    this.selected.keywords.length +
                    this.selected.summaries.length >
                this.nr
            );
        },
        generateKeywords(questionData: IQuestionData): void {
            this.keywords[0] = [];
            questionData.random.keywords.forEach((type: number) => {
                this.keywords[0].push(questionData.keywords[type]);
            });
        },
        generateSummaries(questionData: IQuestionData): void {
            questionData.random.summaries.forEach((types: number[]) => {
                const optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.summaries_per_type[type].pop();
                    optionData.push({
                        content: data ? data.content : '',
                        type: data ? data.type : 0,
                    });
                });
                this.summaries.push(optionData);
            });
        },
        generateScales(questionData: IQuestionData): void {
            questionData.random.scale.forEach((i) => {
                this.scales.push(questionData.scale[i]);
            });
        },
        generateWinners(typeWinners: number[]): void {
            const winners: IOption[] = [];
            typeWinners.forEach((winner, index) => {
                for (const i in this.selected.scales) {
                    const scale = this.selected.scales[i];
                    if (scale.type === winner) {
                        winners.push(scale);
                        break;
                    }
                }
                if (index != winners.length) {
                    for (const i in this.scales) {
                        const scale = this.scales[i];
                        if (scale.type === winner) {
                            winners.push(scale);
                            break;
                        }
                    }
                }
            });
            if (winners.length > 1) {
                this.winners = winners;
                this.next();
            } else {
                this.finish(winners[0]);
            }
        },
        getTitle(): string {
            console.log(this.getSection());
            if (this.getSection() === 'scales') {
                return 'Past het bij jou?';
            } else if (
                (this.getSection() === 'keywords' &&
                    this.nr === this.keywords.length + this.scales.length) ||
                (this.getSection() === 'summaries' &&
                    this.nr ===
                        this.keywords.length +
                            this.scales.length +
                            this.summaries.length +
                            1)
            ) {
                return 'Vergeleken met de rest?';
            } else if (this.getSection() === 'keywords') {
                return 'Verdeel 5 punten';
            } else if (this.getSection() === 'summaries') {
                return 'Kies er ééntje';
            } else {
                return 'Laatste vraag...';
            }
        },
        getSubtitle(): string {
            if (this.getSection() === 'scales') {
                return 'Kies of je het eens bent met de stelling.';
            } else if (
                (this.getSection() === 'keywords' &&
                    this.nr === this.keywords.length + this.scales.length) ||
                (this.getSection() === 'summaries' &&
                    this.nr ===
                        this.keywords.length +
                            this.scales.length +
                            this.summaries.length +
                            1)
            ) {
                return 'Welke van je gekozen antwoorden past het beste bij je?';
            } else if (this.getSection() === 'keywords') {
                return 'Verdeel 5 punten over de kernwoorden die respectievelijk het beste bij je passen.';
            } else if (this.getSection() === 'summaries') {
                return 'Klik op de optie die het beste bij jou past.';
            } else {
                return 'Met deze stellingen was je het eens, maar welke past het beste?';
            }
        },
    },
    created() {
        const questionData: IQuestionData = JSON.parse(this.questionDataRaw);
        this.generateSummaries(questionData);
        this.generateKeywords(questionData);
        this.generateScales(questionData);
    },
});
</script>
