<template>
    <div class="q-progress-bar">
        <div class="q-progress-bar__btn" @click="$emit('prev')" :class="{disabled: !hasPrev}">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title/><g data-name="Layer 2" id="Layer_2"><path d="M10.1,23a1,1,0,0,0,0-1.41L5.5,17H29.05a1,1,0,0,0,0-2H5.53l4.57-4.57A1,1,0,0,0,8.68,9L2.32,15.37a.9.9,0,0,0,0,1.27L8.68,23A1,1,0,0,0,10.1,23Z"/></g></svg>
        </div>
        <div class="q-progress-bar__bar">
            <div class="q-progress-bar__bar__progress" :style="{width: getProgressPercentage()}"></div>
        </div>
        <div class="q-progress-bar__btn next" @click="$emit('next')" :class="{disabled: !hasNext}">
            <svg viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><title/><g data-name="Layer 2" id="Layer_2"><path d="M22,9a1,1,0,0,0,0,1.42l4.6,4.6H3.06a1,1,0,1,0,0,2H26.58L22,21.59A1,1,0,0,0,22,23a1,1,0,0,0,1.41,0l6.36-6.36a.88.88,0,0,0,0-1.27L23.42,9A1,1,0,0,0,22,9Z"/></g></svg>
        </div>
    </div>
</template>
<style lang="scss" scoped>
.q-progress-bar {
    display: flex;
    margin-top: 3rem;
    align-items: center;
    margin-bottom: 1rem;

    &__btn {
        background-color: white;
        border-radius: 50%;
        width: 1rem;
        height: 1rem;
        padding: 0.5rem;
        cursor: pointer;
        box-shadow: 0px 3px 3px rgba(236, 137, 69, 0.2);
        transition: all ease 200ms;

        &.disabled {
            box-shadow: none;
            cursor: auto;
            background-color: #f9e5cd;
            pointer-events: none;
        }

        & svg {
            max-width: 100%;
            max-height: 100%;
            fill: #563118;
        }

        &.next {
            transition-delay: 200ms;
        }
    }

    &__bar {
        background-color: #f9e5cd;
        border-radius: 0.125rem;
        flex: 1;
        height: 0.25rem;
        margin: 0 1rem;

        &__progress {
            border-radius: 0.125rem;
            background-color: #2f9a6e;
            height: 100%;
            transition: all ease 200ms;
            width: 0%;
        }
    }
}
</style>
<script>
export default {
    props: {
        progress: {
            type: Number,
            default: 0
        },
        hasNext: {
            type: Boolean,
            default: false,
        },
        hasPrev: {
            type: Boolean,
            default: true,
        }
    },
    methods: {
        getProgressPercentage: function () {
            return `${this.progress}%`;
        }
    }
}
</script>
