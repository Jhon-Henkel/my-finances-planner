import { IRegisterForm } from '@/modules/register/service/IRegisterForm'
import {ApiRouter} from "@/infra/requst/api/ApiRouter"

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
            if (error.response?.data?.errors?.email) {
                message = 'Email já cadastrado!'
            }
            return {isSuccess: false, data: message}
        })
    }
}
