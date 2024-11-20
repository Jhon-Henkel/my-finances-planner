import {z} from "zod"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"

interface IFormValidation {
    validate: (schema: z.ZodObject<any> | any, data: any) => IFormValidationReturn
}

export const FormValidation: IFormValidation = {
    validate: (schema: z.ZodObject<any> | any, data: any): IFormValidationReturn => {
        const result: z.SafeParseReturnType<any, any> = schema.safeParse(data)
        if (result.success) {
            return {isValid: true, errors: ''}
        }
        const okAlert: MfpOkAlert = new MfpOkAlert("Dados inválidos!")
        okAlert.open(result.error.errors[0].message)
        return {isValid: result.success, errors: result.error.errors[0].message}
    }
}
