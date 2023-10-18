import { describe, it, expect } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import calendarTools from '~js/tools/calendarTools'
import MfpDatePickerRange from '~vue/components/date/DatepickerRange.vue'

describe("Testing DatepickerRange component", () => {
    it ("renders DatepickerRange", async () => {
        const wrapper = shallowMount(MfpDatePickerRange, {
            propsData: {
                date: calendarTools.getThisMonthPeriod()
            }
        })
        expect(wrapper.html()).toContain('<div date="')
        expect(wrapper.html()).toContain('timepicker="false"')
        expect(wrapper.html()).toContain('locale="pt-BR"')
        expect(wrapper.html()).toContain('autoapply="true"')
        expect(wrapper.html()).toContain('format="dd/MM/y"')
    })
})