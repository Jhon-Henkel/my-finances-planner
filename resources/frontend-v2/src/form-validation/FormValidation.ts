import {z} from "zod"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"

interface IFormValidation {
    validate: (schema: z.ZodObject<any>, data: any) => IFormValidationReturn
}

export const FormValidation: IFormValidation = {
    validate: (schema: z.ZodObject<any>, data: any): IFormValidationReturn => {
        const result: z.SafeParseReturnType<any, any> = schema.safeParse(data)
        if (result.success) {
            return {isValid : true, errors: ''}
        }
        return {isValid: result.success, errors: result.error.errors[0].message}
    }
}