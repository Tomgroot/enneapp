<template>
    <div class="container">
<!--    <Scale></Scale>-->
        <Header />
        <Options :options="options" />
        <ProgressBar progress="50" />
    </div>
</template>
<style lang="scss" scoped>
</style>
<script>
import Scale from './components/Scale.vue';
import Options from './components/Options.vue';
import Header from "./components/Header.vue";
import ProgressBar from "./components/ProgressBar.vue";
export default {
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
            options: [
                {title: 'Ik doe dingen vooral omdat ik vind dat ik ze moet doen. Ik doe de dingen het liefst zelf, dan weet ik dat het goed gebeurt.'},
                {title: 'Ik wil weten, de dingen om me heen begrijpen. Kennis is macht. Ik denk voordat ik doe. Ik reageer zelden ad rem. Dat komt omdat ik eerst, de dingen op een rijtje wil hebben.'},
                {title: 'Ik bedenk waanzinnig veel leuke en mooie plannen. Hoe meer adrenaline het oplevert, hoe beter. Soms is het wel een beetje druk in mijn hoofd, dan heb ik veel ideeën. Ik weet het meestal ook zo te brengen dat anderen er enthousiast van worden.'},
            ]
        }
    },
    created() {
        this.questionData = JSON.parse(this.questionDataRaw);
    },
    setup() {

    }
}
</script>
