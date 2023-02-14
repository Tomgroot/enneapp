<template>
    <div class="q-scale">
        <div class="q-scale__title mb-4">{{ title }}</div>
        <div class="q-scale__container">
            <div class="q-scale__label agree" :class="{selected: selected === 1}" @click="select(1)">
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Eens</div>
            </div>
            <div class="q-scale__label neutral" :class="{selected: selected === 2}" @click="select(2)">
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Neutraal</div>
            </div>
            <div class="q-scale__label disagree" :class="{selected: selected === 3}" @click="select(3)">
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Oneens</div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>

.q-scale {
    text-align: center;
    margin-top: 5rem;
    margin-bottom: 5rem;
    padding-bottom: 5rem;
    width: 100%;

    &__title {
        font-size: 1.3rem;
        margin: 0 0.75rem;
    }

    &__container {
        display: flex;
        justify-content: center;
    }

    &__label {
        align-items: center;
        display: flex;
        align-self: center;
        flex-direction: column;
        margin-left: 1rem;
        margin-right: 1rem;
        cursor: pointer;
        font-weight: 600;

        &.selected {
            & .q-scale__checkmark {
                background-color: rgba(86, 49, 24, 0.5);
            }
            &.agree {
                & .q-scale__checkmark {
                    background-color: #2f9a6e;
                }
            }
            &.disagree {
                & .q-scale__checkmark {
                    background-color: #da533f;
                }
            }
        }

        &.agree {
            & .q-scale__checkmark {
                border-color: rgba(47, 154, 110, 0.7);

                &__title {
                    color: #2f9a6e;
                }
            }
        }

        &.disagree {
            & .q-scale__checkmark {
                border-color: rgba(218, 83, 63, 0.5);

                &__title {
                    color: #da533f;
                }
            }
        }
    }

    &__checkmark {
        border-radius: 50%;
        height: 3rem;
        width: 3rem;
        margin-bottom: 0.5rem;
        caret-color: transparent;
        border: 3px solid rgba(86, 49, 24, 0.5);
        transition: all ease 200ms;

        &__title {
            color: rgba(86, 49, 24, 0.8);
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
        title: {
            type: String,
            default: ''
        },
        key: {
            type: Number,
            default: 0
        }
    },
    methods: {
        select: function (i) {
            this.selected = i;
        }
    }
}
</script>
