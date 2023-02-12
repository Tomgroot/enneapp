<template>
    <div class="container">
<!--    <Scale></Scale>-->
        <Header />
        <div class="content">
            <transition name="fade-swipe">
                <Options :options="options" @select="toggleOptions" v-if="showOptions"/>
            </transition>
        </div>
        <ProgressBar @prev="toggleOptions" :progress="50" />
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
        },
    },
    data() {
        return {
            options: [],
            showOptions: true,
        }
    },
    methods: {
        toggleOptions() {
            this.showOptions = !this.showOptions;
        },
    },
    created() {
        this.questionData = JSON.parse(this.questionDataRaw);

        for (const summaries in this.questionData.summaries) {
            //TODO
        }
        console.log(this.questionData);
    },
    setup() {

    }
}
</script>
