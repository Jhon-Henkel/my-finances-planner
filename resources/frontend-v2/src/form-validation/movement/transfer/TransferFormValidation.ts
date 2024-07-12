import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const transferSchema = z.object({
    amount: z.number().min(0, { message: 'Campo "Valor" deve ser maior ou igual a zero' }),
    originId: z.number().min(1, { message: 'Campo "Origem" deve ser selecionado' }),
    destinationId: z.number().min(1, { message: 'Campo "Destino" deve ser selecionado' }),
})

export const TransferFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(transferSchema, data)
    }
}