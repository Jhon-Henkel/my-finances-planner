import {ILoginForm} from "@/services/auth/ILoginForm"
import {ApiRouter} from "@/api/ApiRouter"
import {IApiResponse} from "@/api/IApiResponse"
import {useAuthStore} from "@/stores/auth/AuthStore"

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
            return {isSuccess: true, data: 'Logado com sucesso!'}
        }).catch((response: any): IApiResponse => {
            return {isSuccess: false, data: response?.data?.message ?? 'Usuário ou senha inválidos!'}
        })
    },
    logout: async (): Promise<IApiResponse> => {
        // const data = {
        //     access_token: getAuthStore().token ?? '',
        //     subdomain: getAuthStore().tenancy ?? ''
        // }
        // await ApiRouter.auth.logout(data).then(() => {}).catch(() => {})
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