<template>
    <div class="loading-container">
        <div class="spinner-border text-success mb-2" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script>
    import CalendarTools from "../../js/tools/calendarTools";

    export default {
        name: "LoadingComponent",
        props: {
            time: {
                type: Number,
                default: CalendarTools.twoHundredMs()
            }
        },
        emits: [
            'loading-done'
        ],
        mounted() {
            setTimeout(() =>
                [this.$emit('loading-done')],
                this.time
            )
        }
    }
</script>

<style scoped>
    .loading-container {
        margin: 30% auto auto 50%;
    }
</style>