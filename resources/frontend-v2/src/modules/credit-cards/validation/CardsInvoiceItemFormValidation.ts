import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const futureExpenseSchema = z.object({
    name: z.string().min(1, {message: 'Campo "Descrição" é obrigatório'}),
    value: z.number().min(0, {message: 'Campo "Valor da Parcela" deve ser maior ou igual a zero'}),
    creditCardId: z.number().min(1, {message: 'Campo "Cartão" deve ser selecionado'}),
    nextInstallment: z.string().min(10, {message: 'Campo "Próximo Pagamento" é obrigatório'}),
})

export const CardsInvoiceItemFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(futureExpenseSchema, data)
    }
}