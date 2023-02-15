<template>
    <div class="container">
        <Header :title="getTitle()" :subtitle="getSubtitle()"/>
        <div class="content">
            <Scale
                :title="getScaleTitle()"
                @select="(i) => select(i)"
                :selected="getSelected()"
                v-if="!finishedScales()"
            />
            <transition :name="transition()"
                        v-else-if="finishedScales()">
                <Options
                    :options="getOptions()"
                    @select="(i) => select(i)"
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
            :progress="getProgress()" />
    </div>
</template>
<style lang="scss" scoped>
.content {
    flex: 1;
    display: flex;
    margin-bottom: 3rem;
}
.fade-swipe-enter-active {
    animation: fade-swipe-in .5s;
}
.fade-swipe-leave-active {
    animation: fade-swipe-out .5s;
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
import { defineComponent } from 'vue'
import Scale from './components/Scale.vue';
import Options from './components/Options.vue';
import Header from "./components/Header.vue";
import ProgressBar from "./components/ProgressBar.vue";
import type {IOption, IQuestionData, IScale} from "./types";
import axios from "axios";

export default defineComponent({
    components: {
        ProgressBar,
        Header,
        Scale,
        Options
    },
    props: {
        questionDataRaw: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            options: [] as IOption[][],
            scales: [] as IScale[],
            nr: 0,
            showOptions: true,
            selected: [] as number[],
            nrKeywordsOptions: 0,
        }
    },
    methods: {
        select(selected: number) {
            this.selected[this.nr] = selected;
            this.finishIfDone();
            setTimeout(() => {
                this.next(this.finishedScales() ? 500 : 100);
            }, 200);
        },
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
            return (this.nr / (this.options.length + this.scales.length)) * 100
        },
        hasNext(): boolean {
            return this.selected.length > this.nr;
        },
        finishedScales(): boolean {
            return this.scales.length <= this.nr;
        },
        finishedKeywords(): boolean {
            return this.scales.length + this.nrKeywordsOptions <= this.nr;
        },
        generateOptions(questionData: IQuestionData): void {
            questionData.random.keywords.forEach((types: number[]) => {
                let optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.keywords[type];
                    optionData.push(data);
                });
                this.nrKeywordsOptions++;
                this.options.push(optionData);
            })

            questionData.random.summaries.forEach((types: number[]) => {
                let optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.summaries_per_type[type].pop();
                    optionData.push({
                        content: data ? data.content : '',
                        type: data ? data.type : 0,
                    });
                })
                this.options.push(optionData);
            })
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
                return 'fade-swipe'
            }
            return '';
        },
        getTitle(): string {
            if (!this.finishedScales()) {
                return 'Past het bij jou?';
            } else if (!this.finishedKeywords()) {
                return 'Welke woorden passen?';
            } else {
                return 'Kies er ééntje';
            }
        },
        getSubtitle(): string {
            if (!this.finishedScales()) {
                return 'Kies of je het eens bent met de stelling.';
            } else if (!this.finishedKeywords()) {
                return 'Kies welke woorden het best bij jou persoonlijkheid passen.';
            } else {
                return 'Klik op de optie die het beste bij jou past.';
            }
        },
        finishIfDone(): void {
            if (this.nr + 1 >= this.options.length + this.scales.length) {

                const results = {
                    scales: {} as {[x: number]: number},
                    keywords: {} as {[x: number]: number},
                    summaries: {} as {[x: number]: number},
                }

                for (let i = 1; i <= 9; i ++) {
                    results.scales[i] = 0;
                    results.keywords[i] = 0;
                    results.summaries[i] = 0;
                }

                this.selected.forEach((value, key) => {
                    // Scales
                    if (key < this.scales.length) {
                        if (value === 1) {
                            const type: number = this.scales[key].type
                            results.scales[type]++;
                        }
                    } else {
                        const type: number = this.options[key - this.scales.length][value].type
                        if (key < this.scales.length + this.nrKeywordsOptions) {
                            results.keywords[type]++;
                        } else {
                            results.summaries[type]++;
                        }
                    }
                });
                //TODO can we make top 3?!
                this.$emit('finish', results);
            }
        }
    },
    created() {
        const questionData: IQuestionData = JSON.parse(this.questionDataRaw);
        this.generateOptions(questionData);
        this.generateScales(questionData);
    },
    setup() {

    }
});
</script>
