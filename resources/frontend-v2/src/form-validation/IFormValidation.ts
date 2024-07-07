import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {z} from "zod"

export interface IFormValidation {
    validate: (schema: z.ZodObject<any>, data: any) => IFormValidationReturn
}