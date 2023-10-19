<template>
    <div>
        <VueDatePicker
            v-model="date"
            range
            :auto-apply="autoApply"
            :hide-navigation="hideNavigation"
            :input-class-name="className"
            :preset-dates="presetDates"
            :clearable="false"
            :enable-time-picker="false"
            locale="pt-BR"
            format="dd/MM/y"
            disable-year-select
            @internal-model-change="dateRangeChangedEmit">
            <template #preset-date-range-button="{ label, value, presetDate }">
                <span
                    role="button"
                    :tabindex="0"
                    @click="presetDate(value)"
                    @keyup.enter.prevent="presetDate(value)"
                    @keyup.space.prevent="presetDate(value)">
                    {{ label }}
                </span>
            </template>
        </VueDatePicker>
    </div>
</template>

<script>
import VueDatePicker from '@vuepic/vue-datepicker'
import '@vuepic/vue-datepicker/dist/main.css'
import { ref } from 'vue'
import calendarTools from '~js/tools/calendarTools'

const defaultDateRange = calendarTools.getThisMonthPeriod()

export default {
    name: 'MfpDatePickerRange',
    components: {
        VueDatePicker
    },
    data() {
        return {
            date: ref(defaultDateRange),
            lastDateChanged: null,
            presetDates: ref([
                {
                    label: 'Mês Atual',
                    value: defaultDateRange
                },
                {
                    label: 'Mês Anterior',
                    value: calendarTools.getLastMonthPeriod()
                },
                {
                    label: 'Este Ano',
                    value: calendarTools.getThisYearPeriod()
                },
                {
                    label: 'Ano Anterior',
                    value: calendarTools.getLastYearPeriod()
                }
            ])
        }
    },
    props: {
        autoApply: {
            type: Boolean,
            default: true
        },
        hideNavigation: {
            type: Array,
            default: () => {
                return [
                    'time',
                    'hous',
                    'minutes',
                    'seconds'
                ]
            }
        },
        className: {
            type: String,
            default: 'data-picker-range'
        },
        rangeDate: {
            type: Array,
            required: false
        }
    },
    emits: [
        'dateRangeChanged'
    ],
    methods: {
        dateRangeChangedEmit() {
            if (this.date !== this.lastDateChanged) {
                this.lastDateChanged = this.date
                const dateStart = new Date(this.date[0]).toISOString()
                const dateEnd = new Date(this.date[1]).toISOString()
                this.$emit('dateRangeChanged', [dateStart, dateEnd])
            }
        }
    },
    watch: {
        rangeDate: {
            handler: function(val) {
                this.date = val
            },
            deep: true
        }
    }
}
</script>

<style>
.dp__theme_light {
    --dp-hover-color: #cdf0e9;
    --dp-primary-color: #096452;
}
</style>