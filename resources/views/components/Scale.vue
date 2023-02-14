<template>
    <div class="q-scale">
        <div class="q-scale__title mb-4">{{ title }}</div>
        <div class="q-scale__container">
            <div class="q-scale__label disagree" :class="{selected: selected === 3}" @click="select(3)">
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Oneens</div>
            </div>
            <div class="q-scale__label neutral" :class="{selected: selected === 2}" @click="select(2)">
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Neutraal</div>
            </div>
            <div class="q-scale__label agree" :class="{selected: selected === 1}" @click="select(1)">
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Eens</div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>

.q-scale {
    text-align: center;
    margin-top: 2rem;
    margin-bottom: 2rem;
    width: 100%;

    &__title {
        font-size: 1.2rem;
        margin: 0 1rem 1.75rem;
        font-weight: 600;
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
        -webkit-tap-highlight-color: rgba(0,0,0,0);
        -webkit-tap-highlight-color: transparent;

        &.selected {
            & .q-scale__checkmark {
                background-color: #ec8945;
                box-shadow: 0 2px 3px rgba(218, 83, 63, 0.3);
            }
            &.agree {
                & .q-scale__checkmark {
                    background-color: #2f9a6e;
                    box-shadow: 0 2px 3px rgba(47, 154, 110, 0.3);
                }
            }
            &.disagree {
                & .q-scale__checkmark {
                    background-color: #da533f;
                    box-shadow: 0 2px 3px rgba(218, 83, 63, 0.3);
                }
            }
        }

        &.agree {
            & .q-scale__checkmark {
                box-shadow: 0 0 0 3px rgba(47, 154, 110, 0.3), 0 3px 6px rgba(47, 154, 110, 0.5);

                &__title {
                    color: #2f9a6e;
                }
            }
        }

        &.disagree {
            & .q-scale__checkmark {
                box-shadow: 0 0 0 3px rgba(218, 83, 63, 0.3), 0 3px 6px rgba(218, 83, 63, 0.5);

                &__title {
                    color: #da533f;
                }
            }
        }
    }

    &__checkmark {
        border-radius: 1.8rem;
        height: 4.5rem;
        width: 4.5rem;
        margin-bottom: 1rem;
        caret-color: transparent;
        transition: all ease 200ms;
        background-color: white;
        box-shadow: 0 0 0 3px rgba(236, 137, 69, 0.3), 0 3px 6px rgba(236, 137, 69, 0.5);

        &__title {
            color: #ec8945;
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
            default: 'Ik kan zo opgaan in mijn werk of mijn rol dat ik vergeet dat er nog meer is in het leven.'
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
