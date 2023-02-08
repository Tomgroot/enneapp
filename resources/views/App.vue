<template>
    <Scale></Scale>
</template>
<script>
import Scale from './components/Scale.vue';
export default {
    components: {
        Scale
    },
    props: {
        questionDataRaw: {
            type: String,
            default: ''
        }
    },
    created() {
        this.questionData = JSON.parse(this.questionDataRaw);
    },
    setup() {

    }
}
</script>
