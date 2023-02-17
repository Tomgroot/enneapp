<template>
    <TestPage @finish="(results) => finish(results)" />
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestPage from './pages/TestPage.vue';

export default defineComponent({
    components: {
        TestPage,
    },
    props: {},
    methods: {
        finish(results: number[]): void {
            console.log(results);
        },
    },
});
</script>
