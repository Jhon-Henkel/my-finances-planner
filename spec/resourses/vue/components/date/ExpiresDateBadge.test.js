import { describe, it, expect, vitest } from 'vitest'
import { shallowMount } from '@vue/test-utils'
import MfpExpiresDateBadge from '~vue-component/date/ExpiresDateBadge.vue'
import calendarTools from '~js/tools/calendarTools'

describe("Testing ExpiresDateBadge component", () => {
    it ("Render DatepickerRange Success", async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })
        const wrapper = shallowMount(MfpExpiresDateBadge, {
            propsData: {
                installment: {
                    nextInstallmentDay: '16',
                    firstInstallment: 0
                }
            },
            global: {
                directives: {
                    tooltip: true
                }
            }
        })
        expect(wrapper.html()).toContain('<span class="badge rounded-2 bg-success">16</span>')
    })

    it ("Render DatepickerRange Danger", async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })
        const wrapper = shallowMount(MfpExpiresDateBadge, {
            propsData: {
                installment: {
                    nextInstallmentDay: '2',
                    firstInstallment: 1
                }
            },
            global: {
                directives: {
                    tooltip: true
                }
            }
        })
        expect(wrapper.html()).toContain('<span class="badge rounded-2 bg-danger">2</span>')
    })

    it ("Render DatepickerRange Warning", async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })
        const wrapper = shallowMount(MfpExpiresDateBadge, {
            propsData: {
                installment: {
                    nextInstallmentDay: '20',
                    firstInstallment: 1
                }
            },
            global: {
                directives: {
                    tooltip: true
                }
            }
        })
        expect(wrapper.html()).toContain('<span class="badge rounded-2 bg-warning text-bg-warning">20</span>')
    })

    it ("Render DatepickerRange Warning today", async () => {
        vitest.spyOn(calendarTools, 'getToday').mockImplementation(() => {
            return new Date('2023-10-16')
        })
        const wrapper = shallowMount(MfpExpiresDateBadge, {
            propsData: {
                installment: {
                    nextInstallmentDay: '16',
                    firstInstallment: 1
                }
            },
            global: {
                directives: {
                    tooltip: true
                }
            }
        })
        expect(wrapper.html()).toContain('<span class="badge rounded-2 bg-warning text-bg-warning">16</span>')
    })
})