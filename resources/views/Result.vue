<template>
    <div class="result">
        <Header title="Resultaat" subtitle=""/>
    </div>
</template>
<style lang="scss" scoped>
</style>
<script lang="ts">
import { defineComponent } from 'vue'
import Header from "./components/Header.vue";

export default defineComponent({
    components: {
        Header,
    },
    props: {
        questionDataRaw: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
        }
    },
    methods: {
    },
    created() {
    },
    setup() {
    }
});
</script>
