import { IRegisterForm } from '@/services/register/IRegisterForm'
import {ApiRouter} from "@/api/ApiRouter"

interface IUserRegisterResponse {
    isSuccess: boolean
    data: string
}

export const RegisterService = {
    emptyRegisterData: (): IRegisterForm => {
        return {
            name: '',
            email: '',
            password: '',
            confirmPassword: ''
        }
    },
    register: async (data: IRegisterForm): Promise<IUserRegisterResponse> => {
        return await ApiRouter.user.register(data).then((): IUserRegisterResponse => {
            return {isSuccess: true, data: 'Usuário cadastrado com sucesso!'}
        }).catch((error: any): IUserRegisterResponse => {
            let message: string = 'Erro ao cadastrar usuário!'
            if (error.response?.data?.message?.email) {
                message = 'Email já cadastrado!'
            }
            return {isSuccess: false, data: message}
        })
    }
}
