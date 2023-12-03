<template>
    <span class="badge rounded-2"
          :class="getBadgeTypeForForecastDate(installment)"
          v-tooltip="getTitleForForecastDate(installment)">
        {{ installment.nextInstallmentDay }}
    </span>
</template>

<script>
import CalendarTools from '~js/tools/calendarTools'

export default {
    name: 'MfpExpiresDateBadge',
    props: {
        installment: {
            type: Object,
            required: true
        }
    },
    methods: {
        getBadgeTypeForForecastDate(installment) {
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