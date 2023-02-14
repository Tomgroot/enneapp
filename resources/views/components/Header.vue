<template>
    <div class="q-heading">
        <div class="q-heading__title">
            {{ title }}
        </div>
        <div class="q-heading__subtitle">
            {{ subtitle }}
        </div>
    </div>
</template>
<style lang="scss" scoped>
.q-heading {
    margin-top: 3rem;
    margin-bottom: 2rem;

    &__title {
        font-weight: 700;
        font-size: 2.2rem;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    &__subtitle {
        text-align: center;
        font-size: 1rem;
    }
}
</style>
<script>
export default {
    props: {
        title: {
            type: String,
            default: ""
        },
        subtitle: {
            type: String,
            default: ""
        }
    },
}
</script>
