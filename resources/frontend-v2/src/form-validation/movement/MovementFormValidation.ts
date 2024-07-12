import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const movementSchema = z.object({
    description: z.string().min(1, { message: 'Campo "Descrição" é obrigatório' }),
    type: z.number().min(1, { message: 'Campo "Tipo" deve ser selecionado' }),
    walletId: z.number().min(1, { message: 'Campo "Conta" deve ser selecionado' }),
    amount: z.number().min(0, { message: 'Campo "Valor" deve ser maior ou igual a zero' })
})

export const MovementFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(movementSchema, data)
    }
}