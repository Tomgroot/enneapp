<template>
    <div class="container">
        <TestHeader :title="getTitle()" :subtitle="getSubtitle()" />
        <div class="content">
            <Scale
                :title="getScaleTitle()"
                @select="(i) => select(i)"
                :selected="getSelected()"
                v-if="!finishedScales()"
            />
            <transition :name="transition()" v-else-if="finishedScales()">
                <Options
                    :options="getOptions()"
                    @select="(i, o) => select(i, o)"
                    :selected="getSelected()"
                    v-if="showOptions"
                />
            </transition>
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
.fade-swipe-enter-active {
    animation: fade-swipe-in 0.5s;
}
.fade-swipe-leave-active {
    animation: fade-swipe-out 0.5s;
}
@keyframes fade-swipe-out {
    0% {
        transform: translateX(0rem);
        opacity: 1;
    }
    100% {
        transform: translateX(-10rem);
        opacity: 0;
    }
}
@keyframes fade-swipe-in {
    0% {
        transform: translateX(10rem);
        opacity: 0;
    }
    100% {
        transform: translateX(0rem);
        opacity: 1;
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';
import Scale from './components/Scale.vue';
import Options from './components/Options.vue';
import TestHeader from './components/TestHeader.vue';
import ProgressBar from './components/ProgressBar.vue';
import { calculateResults } from './utils';
import type { IOption, IQuestionData, IResults, IScale } from './types';

export default defineComponent({
    components: {
        ProgressBar,
        TestHeader,
        Scale,
        Options,
    },
    props: {
        questionDataRaw: {
            type: String,
            default: '',
        },
    },
    data() {
        return {
            options: [] as IOption[][],
            scales: [] as IScale[],
            nr: 90,
            showOptions: true,
            selected: [] as number[],
            nrKeywordsOptions: 0,
            keywordsExtraIndex: 0,
        };
    },
    methods: {
        select(selected: number, option: IOption | undefined = undefined) {
            this.selected[this.nr] = selected;
            this.finishIfDone();
            if (option && this.finishedScales() && !this.finishedKeywords()) {
                this.addKeywordOptionsIfKeywords(option);
            }
            setTimeout(() => {
                this.next(this.finishedScales() ? 500 : 100);
            }, 200);
        },
        test() {},
        next(animationDuration = 0) {
            if (animationDuration > 0) {
                this.toggleOptions();
                this.nr++;
                setTimeout(() => {
                    this.toggleOptions();
                }, animationDuration);
            } else {
                this.nr++;
            }
        },
        prev() {
            if (this.nr > 0) {
                this.nr--;
            }
        },
        toggleOptions() {
            this.showOptions = !this.showOptions;
        },
        getOptions(): IOption[] {
            if (this.options[this.nr - this.scales.length]) {
                return this.options[this.nr - this.scales.length];
            }
            return [];
        },
        getSelected(): number | undefined {
            if (this.selected[this.nr] != undefined) {
                return this.selected[this.nr];
            }
            return undefined;
        },
        getProgress(): number {
            return (this.nr / (this.options.length + this.scales.length)) * 100;
        },
        hasNext(): boolean {
            return this.selected.length > this.nr;
        },
        finishedScales(): boolean {
            return this.scales.length <= this.nr;
        },
        finishedKeywords(extraOption = false): boolean {
            if (extraOption) {
                return this.scales.length + this.nrKeywordsOptions < this.nr;
            }
            return this.scales.length + this.nrKeywordsOptions <= this.nr;
        },
        generateOptions(questionData: IQuestionData): void {
            questionData.random.keywords.forEach((types: number[]) => {
                const optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.keywords[type];
                    optionData.push(data);
                });
                this.nrKeywordsOptions++;
                this.options.push(optionData);
            });

            //Add extra space for keywords that have been chosen
            this.keywordsExtraIndex = this.options.length;
            this.options.push([]);

            questionData.random.summaries.forEach((types: number[]) => {
                const optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.summaries_per_type[type].pop();
                    optionData.push({
                        content: data ? data.content : '',
                        type: data ? data.type : 0,
                    });
                });
                this.options.push(optionData);
            });
        },
        generateScales(questionData: IQuestionData): void {
            questionData.random.scale.forEach((i) => {
                this.scales.push(questionData.scale[i]);
            });
        },
        getScaleTitle(): string {
            if (this.scales[this.nr]) {
                return this.scales[this.nr].content;
            } else {
                return '';
            }
        },
        transition(): string {
            if (this.finishedScales()) {
                return 'fade-swipe';
            }
            return '';
        },
        getTitle(): string {
            if (!this.finishedScales()) {
                return 'Past het bij jou?';
            } else if (
                this.nr - this.scales.length ==
                this.keywordsExtraIndex
            ) {
                return 'Vergeleken met de rest?';
            } else if (!this.finishedKeywords(true)) {
                return 'Welke woorden passen?';
            } else {
                return 'Kies er ééntje';
            }
        },
        getSubtitle(): string {
            if (!this.finishedScales()) {
                return 'Kies of je het eens bent met de stelling.';
            } else if (
                this.nr - this.scales.length ==
                this.keywordsExtraIndex
            ) {
                return 'Welke van je gekozen antwoorden past het beste bij je?';
            } else if (!this.finishedKeywords(true)) {
                return 'Kies welke woorden het best bij jou persoonlijkheid passen.';
            } else {
                return 'Klik op de optie die het beste bij jou past.';
            }
        },
        finishIfDone(): void {
            if (this.nr + 1 >= this.options.length + this.scales.length) {
                const results: IResults = calculateResults(
                    this.selected,
                    this.options,
                    this.scales,
                    this.nrKeywordsOptions
                );
                this.$emit('finish', results);
            }
        },
        addKeywordOptionsIfKeywords(result: IOption): void {
            if (
                this.options[this.keywordsExtraIndex].length <
                this.nrKeywordsOptions
            ) {
                this.options[this.keywordsExtraIndex].push(result);
            } else {
                const optionIndex = this.nr - this.scales.length;
                this.options[this.keywordsExtraIndex][optionIndex] = result;
            }
            console.log(
                this.options[this.keywordsExtraIndex],
                this.keywordsExtraIndex
            );
        },
    },
    created() {
        const questionData: IQuestionData = JSON.parse(this.questionDataRaw);
        this.generateOptions(questionData);
        this.generateScales(questionData);
    },
    setup() {},
});
</script>
