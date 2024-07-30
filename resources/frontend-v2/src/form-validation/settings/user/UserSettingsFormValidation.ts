import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const userSettingsSchema = z.object({
    name: z.string().min(1, {message: 'Campo "Nome" é obrigatório'}),
    email: z.string().email({message: 'Campo "E-mail" é obrigatório'}),
    marketPlannerValue: z.number().min(0, {message: 'Campo "Plano para Mercado" deve ser maior ou igual a zero'}),
})

export const UserSettingsFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(userSettingsSchema, data)
    }
}