<template>
    <div class="q-scale">
        <div class="q-scale__title mb-4">{{ title }}</div>
        <div class="q-scale__container">
            <div
                class="q-scale__label disagree"
                :class="{ selected: selected === 3 }"
                @click="select(3)"
            >
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Oneens</div>
            </div>
            <div
                class="q-scale__label neutral"
                :class="{ selected: selected === 2 }"
                @click="select(2)"
            >
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Neutraal</div>
            </div>
            <div
                class="q-scale__label agree"
                :class="{ selected: selected === 1 }"
                @click="select(1)"
            >
                <div class="q-scale__checkmark"></div>
                <div class="q-scale__checkmark__title">Eens</div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/variables';
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
        -webkit-tap-highlight-color: transparent;

        &.selected {
            & .q-scale__checkmark {
                background-color: $orange-color;
                box-shadow: 0 2px 3px rgba($orange-color, 0.3);
            }
            &.agree {
                & .q-scale__checkmark {
                    background-color: $green-color;
                    box-shadow: 0 2px 3px rgba($green-color, 0.3);
                }
            }
            &.disagree {
                & .q-scale__checkmark {
                    background-color: $red-color;
                    box-shadow: 0 2px 3px rgba($red-color, 0.3);
                }
            }
        }

        &.agree {
            & .q-scale__checkmark {
                box-shadow: 0 0 0 3px rgba($green-color, 0.3),
                    0 3px 6px rgba($green-color, 0.5);

                &__title {
                    color: $green-color;
                }
            }
        }

        &.disagree {
            & .q-scale__checkmark {
                box-shadow: 0 0 0 3px rgba($red-color, 0.3),
                    0 3px 6px rgba($red-color, 0.5);

                &__title {
                    color: $red-color;
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
        box-shadow: 0 0 0 3px rgba($orange-color, 0.3),
            0 3px 6px rgba($orange-color, 0.5);

        &__title {
            color: $orange-color;
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        title: {
            type: String,
            default: '',
        },
        selected: {
            type: Number,
            required: false,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    methods: {
        select: function (i: number) {
            if (!this.disabled) {
                this.$emit('select', i);
            }
        },
        isSelected: function (i: number) {
            return this.selected === i;
        },
    },
});
</script>
