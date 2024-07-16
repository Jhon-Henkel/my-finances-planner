import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const cardsPaySchema = z.object({
    walletId: z.number().min(1, {message: 'Campo "Carteira" deve ser selecionado'}),
})

export const CardsPayFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(cardsPaySchema, data)
    }
}