<template>
    <TestPage
        v-if="!results"
        :question-data-raw="questionDataRaw"
        @results="(value, win, selected) => finish(value, win, selected)"
    />
    <EmailPage
        v-else-if="!saved"
        :results="results"
        :selected="selected"
        @saved="save()"
    />
    <ResultPage v-else :results="results" :winner="winner" />
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestPage from './pages/TestPage.vue';
import ResultPage from './pages/ResultPage.vue';
import EmailPage from './pages/EmailPage.vue';
import type { IResults, ISelected } from './types';

export default defineComponent({
    components: {
        ResultPage,
        TestPage,
        EmailPage,
    },
    props: {
        questionDataRaw: {
            type: String,
            default: '',
        },
    },
    data() {
        return {
            results: undefined as IResults | undefined,
            selected: undefined as ISelected | undefined,
            winner: undefined as string | undefined,
            saved: false,
        };
    },
    created() {
        try {
            const results = JSON.parse(localStorage.results);
            if (results && localStorage.winner) {
                this.results = results;
                this.winner = localStorage.winner;
                this.saved = true;
            }
        } catch (e) {
            console.log('Failed parsing the result');
        }
    },
    methods: {
        finish(results: IResults, winner: number, selected: ISelected): void {
            this.results = results;
            this.winner = winner.toString();
            this.selected = selected;
            localStorage.results = JSON.stringify(results);
            localStorage.winner = winner;
        },
        save(): void {
            this.saved = true;
        },
    },
});
</script>
