<template>
    <div class="q-options">
        <div class="q-options__btn" v-for="(option, i) in options"
             :class="{selected: selected === i}" @click="select(i)">{{ option.title }}
        </div>
    </div>
</template>
<style lang="scss" scoped>
.q-options {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;

    &__btn {
        background-color: #fff;
        border-radius: 1.1rem;
        padding: 1.5rem;
        margin-bottom: 0.75rem;
        box-shadow: 0px 3px 3px rgba(236, 137, 69, 0.2);
        transition: all 200ms ease;

        &.selected {
            background-color: rgba(236, 137, 69, 1);
            box-shadow: none;
            color: white;
        }
    }
}
</style>
<script>
export default {
    constructor() {
        this.selected = 0
    },
    data() {
        return {
            selected: this.selected
        }
    },
    props: {
        options: {
            type: Array,
            default: []
        },
    },
    methods: {
        select: function (i) {
            this.selected = i;
        }
    }
}
</script>
