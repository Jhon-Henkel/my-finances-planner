import {z} from "zod"
import {IFormValidation} from "@/infra/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/infra/form-validation/IFormValidationReturn"
import {FormValidation} from "@/infra/form-validation/FormValidation"

const movementSchema = z.object({
    description: z.string().min(1, { message: 'Campo "Descrição" é obrigatório' }),
    type: z.number().min(1, { message: 'Campo "Tipo" deve ser selecionado' }),
    walletId: z.number().min(1, { message: 'Campo "Carteira" deve ser selecionado' }),
    amount: z.number().min(0, { message: 'Campo "Valor" deve ser maior ou igual a zero' })
})

export const MovementFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(movementSchema, data)
    }
}
