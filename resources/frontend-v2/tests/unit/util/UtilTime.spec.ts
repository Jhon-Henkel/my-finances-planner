import {describe, it, expect} from "vitest"
import {UtilTime} from "../../../src/util/UtilTime"

describe('test UtilTime const', () => {
    it('should return one year in ms', () => {
        expect(UtilTime.getOneYearInMs()).toEqual(31536000000)
    })

    it('should return three hours in ms', () => {
        expect(UtilTime.getThreeHoursInMs()).toEqual(10800000)
    })
})
