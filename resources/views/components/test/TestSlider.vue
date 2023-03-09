<template>
    <div class="q-slider">
        <div class="q-slider__content">
            {{ getTitle() }}
        </div>
        <div
            class="q-slider__container"
            @mousedown="startDrag"
            @touchstart="startDrag"
        >
            <div class="q-slider__slider">
                <div
                    class="q-slider__slider__progress"
                    :style="{ width: getSliderValue() }"
                >
                    <div
                        class="q-slider__slider__progress__knob"
                        :class="{ dragging: dragging }"
                    >
                        <div
                            class="q-slider__slider__progress__knob__value"
                            :class="{ dragging: dragging }"
                        >
                            {{ getSliderValue() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/card';
@import './resources/sass/slider';
@import './resources/sass/variables';
.q-slider {
    display: flex;
    flex-direction: column;
    width: 100%;

    &__content {
        @extend %q-card;
    }

    &__container {
        padding: 1rem 0;
    }

    &__slider {
        @extend %q-slider;
        height: 0.313rem;

        &__progress {
            @extend %q-slider__progress;
            position: relative;

            &__knob {
                -webkit-tap-highlight-color: rgba(255, 255, 255, 0);
                position: absolute;
                right: -0.375rem;
                bottom: -0.375rem;
                background-color: $green-color;
                border-radius: 50%;
                width: 0.375rem;
                height: 0.375rem;
                padding: 0.375rem;
                cursor: pointer;
                transition: 200ms ease transform, 200ms ease padding;

                &:hover,
                &.dragging {
                    transform: scale(1.3);
                }

                &__value {
                    position: absolute;
                    bottom: 100%;
                    right: -65%;
                    background-color: $green-color;
                    margin-bottom: 0.75rem;
                    color: white;
                    border-radius: 50%;
                    height: 2.5rem;
                    width: 2.5rem;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    font-size: 0.8rem;
                    transition: 200ms ease transform, 200ms ease opacity;
                    transform: scale(0) translateY(100%);
                    opacity: 0;

                    &.dragging {
                        transform: scale(1) translateY(0);
                        opacity: 1;
                    }

                    &:before {
                        content: '';
                        position: absolute;
                        top: 85%;
                        left: 50%;
                        transform: translateX(-50%);
                        border-left: 0.8rem solid transparent;
                        border-right: 0.8rem solid transparent;
                        border-top: 0.7rem solid $green-color;
                    }
                }
            }
        }
    }
}
</style>
<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    props: {
        option: {
            type: Object,
        },
        selected: {
            type: Number,
            default: 50,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            sliderValue: 50,
            dragging: false,
        };
    },
    methods: {
        getTitle(): string {
            if (this.option && this.option.content) {
                return this.option.content;
            }
            return '';
        },
        getSliderValue(): string {
            if (this.selected >= 0 && !this.dragging) {
                this.sliderValue = this.selected;
            }
            if (this.sliderValue) {
                return `${this.sliderValue}%`;
            }
            return '0%';
        },
        startDrag(event: MouseEvent | TouchEvent) {
            const handleMouseDown = (event: MouseEvent | TouchEvent) => {
                if (this.disabled) {
                    return;
                }
                this.dragging = true;
                const leftLocation = this.$el.getBoundingClientRect().left;
                const width = this.$el.getBoundingClientRect().width;
                const mouseX =
                    event instanceof MouseEvent
                        ? event.clientX
                        : event.touches[0].clientX;
                const relativeLeft =
                    Math.max(leftLocation, mouseX) - leftLocation;
                this.sliderValue = Math.min(
                    Math.round((relativeLeft / width) * 100),
                    100
                );
            };

            handleMouseDown(event);
            document.addEventListener('mousemove', handleMouseDown);
            document.addEventListener('touchmove', handleMouseDown);

            const stopSlider = () => {
                if (this.disabled) {
                    return;
                }
                this.dragging = false;
                document.removeEventListener('mousemove', handleMouseDown);
                document.removeEventListener('touchmove', handleMouseDown);
                this.$emit('select', this.sliderValue);
            };

            document.onmouseup = stopSlider;
            document.onmouseleave = stopSlider;

            document.ontouchcancel = stopSlider;
            document.ontouchend = stopSlider;

            window.onresize = stopSlider;
        },
    },
});
</script>
