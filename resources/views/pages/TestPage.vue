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
                :nr="nr - this.scales.length - this.keywords.length - 1"
                @next="(selection) => selectSummaries(selection)"
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
import type { IOption, IQuestionData, ISelected, IScale } from '../types';
import ScaleSection from '../components/ScaleSection.vue';
import KeywordSection from '../components/KeywordSection.vue';
import SummarySection from '../components/SummarySection.vue';
import { calculateResults } from '../utils';

export default defineComponent({
    components: {
        SummarySection,
        KeywordSection,
        ScaleSection,
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
                scales: [] as IScale[],
                keywords: [] as IOption[],
                summaries: [] as IOption[],
            } as ISelected,
            scales: [] as IScale[],
            keywords: [] as IOption[][],
            summaries: [] as IOption[][],
            nr: 80,
            transition: 'fade-swipe',
        };
    },
    methods: {
        selectScale(selected: IScale[]): void {
            this.selected.scales = selected;
            this.transition = 'fade-swipe';
            this.next();
        },
        selectKeywords(selected: IOption[]): void {
            this.selected.keywords = selected;
            this.transition = 'fade-swipe';
            this.next();
        },
        selectSummaries(selected: IOption[]): void {
            this.selected.summaries = selected;
            this.transition = 'fade-swipe';
            this.next();
        },
        getSection(): string {
            if (this.nr < this.scales.length) {
                return 'scales';
            } else if (
                this.nr <
                this.scales.length + this.keywords.length + 1
            ) {
                return 'keywords';
            } else {
                return 'summaries';
            }
        },
        next() {
            this.nr++;
            if (
                this.nr >
                this.scales.length +
                    this.keywords.length +
                    this.summaries.length
            ) {
                this.finish();
            }
        },
        finish() {
            const results = calculateResults(this.selected);
            console.log('FINISH', this.selected, results);
            this.$emit('finish', results);
        },
        prev() {
            this.transition = 'gone';
            if (this.nr > 0) {
                this.nr--;
            }
        },
        getProgress(): number {
            return (
                (this.nr /
                    (this.keywords.length +
                        this.summaries.length +
                        this.scales.length)) *
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
            questionData.random.keywords.forEach((types: number[]) => {
                const optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.keywords[type];
                    optionData.push(data);
                });
                this.keywords.push(optionData);
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
        getTitle(): string {
            if (this.getSection() === 'scales') {
                return 'Past het bij jou?';
            } else if (
                this.getSection() === 'keywords' &&
                this.nr === this.keywords.length + this.scales.length
            ) {
                return 'Vergeleken met de rest?';
            } else if (this.getSection() === 'keywords') {
                return 'Welke woorden passen?';
            } else {
                return 'Kies er ééntje';
            }
        },
        getSubtitle(): string {
            if (this.getSection() === 'scales') {
                return 'Kies of je het eens bent met de stelling.';
            } else if (
                this.getSection() === 'keywords' &&
                this.nr === this.keywords.length + this.scales.length
            ) {
                return 'Welke van je gekozen antwoorden past het beste bij je?';
            } else if (this.getSection() === 'keywords') {
                return 'Kies welke woorden het best bij jou persoonlijkheid passen.';
            } else {
                return 'Klik op de optie die het beste bij jou past.';
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
