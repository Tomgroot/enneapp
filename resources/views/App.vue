<template>
    <TestPage
        v-if="!results"
        :question-data-raw="questionDataRaw"
        @results="(value, win) => finish(value, win)"
    />
    <EmailPage v-else-if="!saved" />
    <ResultPage v-else :results="results" :winner="winner" />
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestPage from './pages/TestPage.vue';
import ResultPage from './pages/ResultPage.vue';
import EmailPage from './pages/EmailPage.vue';
import type { IResults } from './types';

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
            }
        } catch (e) {
            console.log('Failed parsing the result');
        }
    },
    methods: {
        finish(results: IResults, winner: number): void {
            this.results = results;
            this.winner = winner.toString();
            localStorage.results = JSON.stringify(results);
            localStorage.winner = winner;
        },
    },
});
</script>
