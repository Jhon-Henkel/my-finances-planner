import {z} from "zod"
import {IFormValidation} from "@/infra/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/infra/form-validation/IFormValidationReturn"
import {FormValidation} from "@/infra/form-validation/FormValidation"

const futureProfitSchema = z.object({
    description: z.string().min(1, {message: 'Campo "Descrição" é obrigatório'}),
    amount: z.number().min(0, {message: 'Campo "Valor da Parcela" deve ser maior ou igual a zero'}),
    walletId: z.number().min(1, {message: 'Campo "Carteira" deve ser selecionado'}),
    forecast: z.string().min(10, {message: 'Campo "Próximo Recebimento" é obrigatório'}),
})

export const EarningPlanFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(futureProfitSchema, data)
    }
}
