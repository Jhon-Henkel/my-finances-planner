import {ILoginForm} from "@/services/auth/ILoginForm"
import {ApiRouter} from "@/api/ApiRouter"
import {IApiResponse} from "@/api/IApiResponse"
import {useAuthStore} from "@/stores/auth/AuthStore"
import {MfpSubscriptionService} from "@/services/subscription/MfpSubscriptionService"

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
            return {isSuccess: false, data: response?.data?.message ?? 'Usuário ou senha inválidos!'}
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
