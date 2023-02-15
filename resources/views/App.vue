<template>
    <Test @finish="(results) => finish(results)"/>
</template>
<style lang="scss" scoped>
</style>
<script lang="ts">
import { defineComponent } from 'vue'
import Test from './Test.vue';

export default defineComponent({
    components: {
        Test,
    },
    props: {
    },
    methods: {
        finish(results: number[]): void {
            console.log(results);
        }
    },
    created() {
    },
    setup() {
    }
});
</script>
