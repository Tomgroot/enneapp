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
        font-size: 2.5rem;
        text-align: center;
        margin-bottom: 0.5rem;
    }

    &__subtitle {
        text-align: center;
    }
}
</style>
<script>
export default {
    props: {
        title: {
            type: String,
            default: "Kies er ééntje"
        },
        subtitle: {
            type: String,
            default: "Klik op de optie die het beste bij jou past"
        }
    },
}
</script>
