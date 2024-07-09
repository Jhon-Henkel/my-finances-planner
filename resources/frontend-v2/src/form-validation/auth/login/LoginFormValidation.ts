import {z} from "zod"
import {FormValidation} from "@/form-validation/FormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {IFormValidation} from "@/form-validation/IFormValidation"

const loginSchema: z.ZodObject<{email: z.ZodString, password: z.ZodString}> = z.object({
    email: z.string().email({ message: 'Campo "Email" deve ser um e-mail válido!' }),
    password: z.string().min(8, { message: 'Campo "Senha" deve ter no mínimo 8 caracteres!' })
})

export const LoginFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(loginSchema, data)
    }
}