<template>
    <div class="container">
        <TestHeader :title="getTitle()" :subtitle="getSubtitle()" />
        <div class="content">
            <StatementSection
                :statements="statements"
                :nr="nr"
                :current="getSection() === 'statements'"
                @next="(selection) => selectStatements(selection)"
            />
            <KeywordSection
                :keywords="keywords"
                :nr="nr - this.statements.length"
                :current="getSection() === 'keywords'"
                :transition="transition"
                @next="(selection) => selectKeywords(selection)"
            />
            <SummarySection
                :summaries="summaries"
                :current="getSection() === 'summaries'"
                :transition="transition"
                :nr="nr - this.statements.length - this.keywords.length"
                @next="(selection) => selectSummaries(selection)"
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
import StatementSection from '../components/StatementSection.vue';
import KeywordSection from '../components/KeywordSection.vue';
import SummarySection from '../components/SummarySection.vue';
import WinnerSection from '../components/WinnerSection.vue';
import { calculateResults } from '../utils';

export default defineComponent({
    components: {
        SummarySection,
        KeywordSection,
        StatementSection,
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
                statements: [] as ISelectedPoints[],
                keywords: [] as IDividedPoints[][],
                summaries: [] as IDividedPoints[],
            } as ISelected,
            statements: [] as IScale[],
            keywords: [] as IOption[][],
            summaries: [] as IOption[],
            winners: [] as IOption[],
            nr: 0,
            transition: true,
        };
    },
    methods: {
        selectStatements(selected: ISelectedPoints[]): void {
            this.selected.statements = selected;
            this.transition = true;
            this.next();
        },
        selectKeywords(selected: IDividedPoints[][]): void {
            this.selected.keywords = selected;
            this.transition = true;
            this.next();
        },
        selectSummaries(selected: IDividedPoints[]): void {
            this.selected.summaries = selected;
            this.transition = true;
            this.next();
        },
        selectWinner(winner: IOption): void {
            this.finish(winner);
        },
        getSection(): string {
            if (this.nr < this.statements.length) {
                return 'statements';
            } else if (
                this.nr <
                this.statements.length + this.keywords.length
            ) {
                return 'keywords';
            } else if (this.winners.length > 0) {
                return 'winners';
            } else {
                return 'summaries';
            }
        },
        next() {
            this.nr++;
            if (
                this.nr >=
                    this.statements.length +
                        this.keywords.length +
                        this.summaries.length &&
                (!this.winners || this.winners.length == 0)
            ) {
                this.finish();
            }
        },
        finish(winner: IOption | undefined = undefined) {
            const results = calculateResults(this.selected);
            if (results.winners.length > 1 && !winner) {
                this.generateWinners(results.winners);
            } else {
                this.nr = 999;
                const win =
                    winner && winner.type ? winner.type : results.winners[0];
                if (results.winners.length > 1) {
                    results.winners = [win];
                }
                this.$emit('results', results, win, this.selected);
            }
        },
        prev() {
            this.transition = false;
            if (this.nr > 0) {
                this.nr--;
            }
        },
        getProgress(): number {
            return Math.min(
                (this.nr /
                    (this.keywords.length +
                        this.summaries.length +
                        this.statements.length)) *
                    100,
                100
            );
        },
        hasNext(): boolean {
            return (
                !this.transition &&
                this.selected.statements.length +
                    this.selected.keywords.length +
                    this.selected.summaries.length >
                    this.nr
            );
        },
        // FOR TESTING ONLY! DO NOT USE ON PRODUCTION.
        generateTestSelectedAndFinish(questionData: IQuestionData): void {
            const keywordsIndex = questionData.random.keywords[0];
            const keywordsIndexTwo = questionData.random.keywords[1];
            this.selected.keywords.push([
                {
                    ...questionData.keywords[keywordsIndex],
                    points: 3,
                },
                {
                    ...questionData.keywords[keywordsIndexTwo],
                    points: 2,
                },
            ]);

            for (
                let i = 0;
                i < questionData.random.summaries.length && i < 10;
                i++
            ) {
                const index = questionData.random.summaries[i];
                this.selected.summaries.push({
                    ...questionData.summaries[index],
                    points: 77,
                });
            }

            for (
                let i = 0;
                i < questionData.random.statements.length && i < 10;
                i++
            ) {
                const index = questionData.random.statements[i];
                this.selected.statements.push({
                    ...questionData.statements[index],
                    points: 5,
                });
            }
            this.finish();
        },
        generateKeywords(questionData: IQuestionData): void {
            this.keywords[0] = [];
            questionData.random.keywords.forEach((index: number) => {
                this.keywords[0].push(questionData.keywords[index]);
            });
        },
        generateSummaries(questionData: IQuestionData): void {
            questionData.random.summaries.forEach((index: number) => {
                this.summaries.push(questionData.summaries[index]);
            });
        },
        generateStatements(questionData: IQuestionData): void {
            questionData.random.statements.forEach((i) => {
                this.statements.push(questionData.statements[i]);
            });
        },
        generateWinners(typeWinners: number[]): void {
            const winners: IOption[] = [];
            typeWinners.forEach((winner, index) => {
                for (const i in this.selected.statements) {
                    const statement = this.selected.statements[i];
                    if (statement.type === winner) {
                        winners.push(statement);
                        break;
                    }
                }
                if (index < winners.length) {
                    for (const i in this.statements) {
                        const statement = this.statements[i];
                        if (statement.type === winner) {
                            winners.push(statement);
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
            if (this.getSection() === 'statements') {
                return 'Past het bij jou?';
            } else if (
                (this.getSection() === 'keywords' &&
                    this.nr ===
                        this.keywords.length + this.statements.length) ||
                (this.getSection() === 'summaries' &&
                    this.nr ===
                        this.keywords.length +
                            this.statements.length +
                            this.summaries.length +
                            1)
            ) {
                return 'Vergeleken met de rest?';
            } else if (this.getSection() === 'keywords') {
                return 'Verdeel 5 punten';
            } else if (this.getSection() === 'summaries') {
                return 'Hoeveel past het bij jou?';
            } else {
                return 'Laatste vraag...';
            }
        },
        getSubtitle(): string {
            if (this.getSection() === 'statements') {
                return 'Kies of je het eens bent met de stelling.';
            } else if (
                (this.getSection() === 'keywords' &&
                    this.nr ===
                        this.keywords.length + this.statements.length) ||
                (this.getSection() === 'summaries' &&
                    this.nr ===
                        this.keywords.length +
                            this.statements.length +
                            this.summaries.length +
                            1)
            ) {
                return 'Welke van je gekozen antwoorden past het beste bij je?';
            } else if (this.getSection() === 'keywords') {
                return 'Verdeel 5 punten over de kernwoorden die respectievelijk het beste bij je passen.';
            } else if (this.getSection() === 'summaries') {
                return 'Op een schaal van 100%, hoe goed past het statement bij jou? Sleep de groene slider naar links of naar rechts.';
            } else {
                return 'Met deze stellingen was je het eens, maar welke past het beste?';
            }
        },
    },
    created() {
        const questionData: IQuestionData = JSON.parse(this.questionDataRaw);
        this.generateSummaries(questionData);
        this.generateKeywords(questionData);
        this.generateStatements(questionData);
    },
});
</script>
