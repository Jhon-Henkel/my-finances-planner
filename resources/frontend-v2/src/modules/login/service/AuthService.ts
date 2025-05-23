import {ILoginForm} from "@/modules/login/service/ILoginForm"
import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {IApiResponse} from "@/infra/requst/api/IApiResponse"
import {useAuthStore} from "@/modules/login/store/AuthStore"
import {MfpSubscriptionService} from "@/modules/subscription/service/MfpSubscriptionService"

let authStore: any = null

function getAuthStore() {
    if (authStore === null) {
        authStore = useAuthStore()
    }
    return authStore
}

export const AuthService = {
    login: async (data: ILoginForm): Promise<IApiResponse> => {
        return await ApiRouter.auth.login(data).then((response: any): IApiResponse => {
            getAuthStore().setUser(response.user)
            getAuthStore().setToken(response.token)
            if (response.user.plan === 'Free' && response.must_show_welcome_page === false) {
                MfpSubscriptionService.openModal('Você tem limitações de uso no plano gratuito.')
            }
            return {isSuccess: true, data: response}
        }).catch((response: any): IApiResponse => {
            if (response.status === 419) {
                window.location.href = '/v2/login'
            }
            let message = response?.data?.message
            if (response.message) {
                message = response.message
                if (message.includes('timeout of ')) {
                    message = 'Tempo limite excedido, tente novamente...'
                }
            }
            return {isSuccess: false, data: message ?? 'Usuário ou senha inválidos!'}
        })
    },
    logout: async (): Promise<IApiResponse> => {
        getAuthStore().logout()
        return {isSuccess: true, data: 'Deslogado com sucesso!'}
    },
    emptyLoginObject: (): ILoginForm => {
        return {
            email: '',
            password: ''
        }
    },
    isUserLogged: (): boolean => {
        return getAuthStore().isAuthUser()
    },
    getRememberedEmail: (): string => {
        return getAuthStore().getEmail
    },
    getToken: (): string => {
        return getAuthStore().getToken?.value ?? ''
    },
}
