import {z} from "zod"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"
import {IFormValidation} from "@/form-validation/IFormValidation"

export const walletSchema: z.ZodObject<{ name: z.ZodString, amount: z.ZodNumber }> = z.object({
    name: z.string().min(1, {message: 'Campo "Descrição" é obrigatório'}),
    amount: z.number().min(0, {message: 'Campo "Valor" deve ser maior ou igual a zero'})
})

export const WalletFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(walletSchema, data)
    }
}