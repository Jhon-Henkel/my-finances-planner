import {z} from "zod"
import {IFormValidation} from "@/form-validation/IFormValidation"
import {IFormValidationReturn} from "@/form-validation/IFormValidationReturn"
import {FormValidation} from "@/form-validation/FormValidation"

const userRegisterSchema = z.object({
    name: z.string().min(2, {message: 'Campo "Seu Nome" deve ter no mínimo 2 caracteres'}),
    email: z.string().email({message: 'Campo "Email" deve ser um e-mail válido'}),
    password: z.string().min(8, {message: 'Campo "Senha" deve ter no mínimo 8 caracteres'}),
    confirmPassword: z.string().min(8, {message: 'Campo "Confirmar Senha" deve ter no mínimo 8 caracteres'})
}).refine(data => data.password === data.confirmPassword, {
    message: 'As senhas devem ser iguais!',
    path: ['confirmPassword']
})

export const UserRegisterFormValidation: IFormValidation = {
    validate: (data: any): IFormValidationReturn => {
        return FormValidation.validate(userRegisterSchema, data)
    }
}
