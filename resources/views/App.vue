<template>
    <div class="container">
        <Header title="Past het bij jou?" subtitle="Kies of je het eens bent met de stelling."/>
        <div class="content">
            <transition name="fade-swipe">
                <Options
                    :options="getOptions()"
                    @select="(i) => selectOption(i)"
                    v-if="showOptions && 1 === 2"
                    :selected="getSelected()"
                />
            </transition>
            <Scale />
        </div>
        <ProgressBar
            @prev="prevOption"
            @next="nextOption"
            :has-prev="this.option_nr > 0"
            :has-next="hasNext()"
            :progress="getProgress()" />
    </div>
</template>
<style lang="scss" scoped>
.content {
    flex: 1;
    display: flex;
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
import type {IOption, IQuestionData } from "./types";

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
            option_nr: 0,
            showOptions: true,
            selected: [] as number[],
        }
    },
    methods: {
        selectOption(selected: number) {
            this.selected[this.option_nr] = selected;
            setTimeout(() => {
                this.nextOption(true);
            }, 200);
        },
        nextOption(animation = false) {
            if (animation) {
                this.toggleOptions();
                this.option_nr++;
                setTimeout(() => {
                    this.toggleOptions();
                }, 500);
            } else {
                this.option_nr++;
            }
        },
        prevOption() {
            if (this.option_nr > 0) {
                this.option_nr--;
            }
        },
        toggleOptions() {
            this.showOptions = !this.showOptions;
        },
        getOptions(): IOption[] {
            if (this.options[this.option_nr]) {
                return this.options[this.option_nr];
            }
            return [];
        },
        getSelected(): number | undefined {
            if (this.selected[this.option_nr] != undefined) {
                return this.selected[this.option_nr];
            }
            return undefined;
        },
        getProgress(): number {
            return (this.option_nr / this.options.length) * 100
        },
        hasNext(): boolean {
            return this.selected.length > this.option_nr;
        },
        generateOptions(questionData: IQuestionData): void {
            questionData.random.summaries.forEach((types: number[]) => {
                let optionData: IOption[] = [];
                types.forEach((type: number) => {
                    const data = questionData.summaries_per_type[type].pop();
                    optionData.push({
                        content: data ? data.content : '',
                    });
                })
                this.options.push(optionData);
            })
        },
        generateScales(questionData: IQuestionData): void {

        }
    },
    created() {
        const questionData: IQuestionData = JSON.parse(this.questionDataRaw);
        this.generateOptions(questionData);
    },
    setup() {

    }
});
</script>
