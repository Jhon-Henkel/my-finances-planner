import {z} from "zod"
import {IFormValidation} from "@/infra/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/infra/form-validation/IFormValidationReturn"
import {FormValidation} from "@/infra/form-validation/FormValidation"

const cardsPaySchema = z.object({
    walletId: z.number().min(1, {message: 'Campo "Carteira" deve ser selecionado'}),
})

export const CreditCardPayFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(cardsPaySchema, data)
    }
}
