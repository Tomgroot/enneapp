<template>
    <div class="result">
        <TestHeader title="Resultaat" subtitle="" />
    </div>
</template>
<style lang="scss" scoped></style>
<script lang="ts">
import { defineComponent } from 'vue';
import TestHeader from './components/TestHeader.vue';

export default defineComponent({
    components: {
        TestHeader,
    },
    props: {
        questionDataRaw: {
            type: String,
            default: '',
        },
    },
    data() {
        return {};
    },
});
</script>
