<template>
    <div class="q-progress-bar">
        <div
            class="q-progress-bar__btn"
            @click="$emit('prev')"
            :class="{ disabled: !hasPrev }"
        >
            <svg height="512px" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M189.3,128.4L89,233.4c-6,5.8-9,13.7-9,22.4c0,8.7,3,16.5,9,22.4l100.3,105.4c11.9,12.5,31.3,12.5,43.2,0  c11.9-12.5,11.9-32.7,0-45.2L184.4,288h217c16.9,0,30.6-14.3,30.6-32c0-17.7-13.7-32-30.6-32h-217l48.2-50.4  c11.9-12.5,11.9-32.7,0-45.2C220.6,115.9,201.3,115.9,189.3,128.4z"/></svg>
        </div>
        <div class="q-progress-bar__bar">
            <div
                class="q-progress-bar__bar__progress"
                :style="{ width: getProgressPercentage() }"
            ></div>
        </div>
        <div
            class="q-progress-bar__btn next"
            @click="$emit('next')"
            :class="{ disabled: !hasNext }"
        >
            <svg height="512px" version="1.1" viewBox="0 0 512 512" width="512px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M322.7,128.4L423,233.4c6,5.8,9,13.7,9,22.4c0,8.7-3,16.5-9,22.4L322.7,383.6c-11.9,12.5-31.3,12.5-43.2,0  c-11.9-12.5-11.9-32.7,0-45.2l48.2-50.4h-217C93.7,288,80,273.7,80,256c0-17.7,13.7-32,30.6-32h217l-48.2-50.4  c-11.9-12.5-11.9-32.7,0-45.2C291.4,115.9,310.7,115.9,322.7,128.4z"/></svg>
        </div>
    </div>
</template>
<style lang="scss" scoped>
@import './resources/sass/slider';
@import './resources/sass/variables';
.q-progress-bar {
    display: flex;
    position: fixed;
    align-items: center;
    bottom: 1rem;
    right: 1rem;
    left: 1rem;
    max-width: 560px;
    margin: 0 auto;
    background-color: $bg-color;
    box-shadow: 0 20px 20px 35px $bg-color;

    &__btn {
        background-color: white;
        border-radius: 50%;
        width: 1.5rem;
        height: 1.5rem;
        padding: 0.75rem;
        cursor: pointer;
        box-shadow: 0 3px 9px rgba($orange-color, 0.4);
        transition: all ease 200ms;
        -webkit-tap-highlight-color: transparent;

        &.disabled {
            box-shadow: none;
            cursor: auto;
            background-color: $darker-bg-color;
            pointer-events: none;
        }

        & svg {
            max-width: 100%;
            max-height: 100%;
            fill: $text-color;
        }
    }

    &__bar {
        @extend %q-slider;
        flex: 1;
        height: 0.5rem;
        margin: 0 1rem;

        &__progress {
            @extend %q-slider__progress;
            transition: all ease 200ms;
        }
    }
}
</style>
<script>
export default {
    props: {
        progress: {
            type: Number,
            default: 0,
        },
        hasNext: {
            type: Boolean,
            default: false,
        },
        hasPrev: {
            type: Boolean,
            default: true,
        },
    },
    methods: {
        getProgressPercentage: function () {
            return `${this.progress}%`;
        },
    },
};
</script>
