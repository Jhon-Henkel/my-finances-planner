import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const futureExpenseSchema = z.object({
    description: z.string().min(1, {message: 'Campo "Descrição" é obrigatório'}),
    amount: z.number().min(0, {message: 'Campo "Valor da Parcela" deve ser maior ou igual a zero'}),
    walletId: z.number().min(1, {message: 'Campo "Carteira" deve ser selecionado'}),
    forecast: z.string().min(10, {message: 'Campo "Próximo Pagamento" é obrigatório'}),
})

export const FutureExpenseFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(futureExpenseSchema, data)
    }
}