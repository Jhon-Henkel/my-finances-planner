<template>
    <span class="badge rounded-2"
          :class="getBadgeTypeForForecastDate(installment)"
          v-tooltip="getTitleForForecastDate(installment)">
        <font-awesome-icon :icon="IconEnum.calendarCheck()" v-show="showCalendarIcon"/>
        {{ installment.nextInstallmentDay }}
    </span>
</template>

<script>
import CalendarTools from '~js/tools/calendarTools'
import IconEnum from '~js/enums/iconEnum'

export default {
    name: 'MfpExpiresDateBadge',
    computed: {
        IconEnum() {
            return IconEnum
        }
    },
    props: {
        installment: {
            type: Object,
            required: true
        },
        showCalendarIcon: {
            type: Boolean,
            default: false
        },
        alwaysSuccessBadge: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        getBadgeTypeForForecastDate(installment) {
            if (this.alwaysSuccessBadge) {
                return 'bg-success'
            }
            const today = CalendarTools.getToday().getDate()
            const nextInstallmentDay = parseInt(installment.nextInstallmentDay)
            if ((nextInstallmentDay < today) && (installment.firstInstallment > 0)) {
                return 'bg-danger'
            } else if ((nextInstallmentDay >= today) && (installment.firstInstallment > 0)) {
                return 'bg-warning text-bg-warning'
            }
            return 'bg-success'
        },
        getTitleForForecastDate(installment) {
            const today = CalendarTools.getToday().getDate()
            const nextInstallmentDay = parseInt(installment.nextInstallmentDay)
            if ((nextInstallmentDay < today) && (installment.firstInstallment > 0)) {
                return 'Atrasado'
            } else if ((nextInstallmentDay > today) && (installment.firstInstallment > 0)) {
                return 'Prestes a Vencer'
            }
            return 'Em dia'
        }
    }
}
</script>