import {z} from "zod"
import {IFormValidation} from "@/infra/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/infra/form-validation/IFormValidationReturn"
import {FormValidation} from "@/infra/form-validation/FormValidation"

const cardsSchema = z.object({
    name: z.string().min(1, {message: 'Campo "Nome" é obrigatório'}),
    limit: z.number().min(0, {message: 'Campo "Limite Total" deve ser maior ou igual a zero'}),
    dueDate: z.number()
        .min(1, {message: 'Campo "Dia Vencimento" deve ser maior que zero'})
        .max(31, {message: 'Campo "Dia Vencimento" deve ser menor ou igual a 31'}),
    closingDay: z.number()
        .min(1, {message: 'Campo "Dia Vencimento" deve ser maior que zero'})
        .max(31, {message: 'Campo "Dia Vencimento" deve ser menor ou igual a 31'}),
})

export const CreditCardFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(cardsSchema, data)
    }
}
