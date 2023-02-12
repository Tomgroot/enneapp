<template>
    <div class="q-scale active">
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
    opacity: 0.5;
    border-bottom: 1px solid #dddfe2;

    &.active {
        opacity: 1;
    }

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

        &.selected {
            & .q-scale__checkmark {
                background-color: rgb(176, 198, 206);
            }
            &.agree {
                & .q-scale__checkmark {
                    background-color: #329F5B;
                }
            }
            &.disagree {
                & .q-scale__checkmark {
                    background-color: #C42021;
                }
            }
        }

        &.agree {
            & .q-scale__checkmark {
                border-color: #329F5B;

                &__title {
                    color: #329F5B;
                }
            }
        }

        &.disagree {
            & .q-scale__checkmark {
                border-color: #C42021;

                &__title {
                    color: #C42021;
                }
            }
        }
    }

    &__checkmark {
        border-radius: 50%;
        height: 2rem;
        width: 2rem;
        margin-bottom: 0.5rem;
        caret-color: transparent;
        border: 3px solid rgb(176, 198, 206);

        &__title {
            color: rgb(176, 198, 206);
        }
    }
}

.q-scale .container label:first-child input:checked ~ .checkmark {
    background-color: #329F5B;
}

.q-scale .container label:first-child .checkmark {
    border-color: #329F5B;
}

.q-scale .container label:first-child .checkmark-title {
    color: #329F5B;
}

.q-scale .container label:last-child input:checked ~ .checkmark {
    background-color: #C42021;
}

.q-scale .container label:last-child .checkmark {
    border-color: #C42021;
}

.q-scale .container label:last-child .checkmark-title {
    color: #C42021;
}

.q-scale .title {
    margin-bottom: 0.5rem;
}

.q-scale input[type='radio'] {
    visibility: hidden;
    position: absolute;
}

.q-scale input[type='radio']:checked ~ .checkmark {
    background-color: rgb(176, 198, 206);
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
