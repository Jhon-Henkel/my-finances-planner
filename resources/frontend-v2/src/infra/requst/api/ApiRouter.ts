import axios from "axios"
import {ILoginForm} from "@/modules/login/service/ILoginForm"
import {AuthService} from "@/modules/login/service/AuthService"
import {IWalletForm} from "@/modules/wallet/service/IWalletForm"
import {MfpOkAlert} from "@/modules/@shared/components/alert/MfpOkAlert"
import {IMovementForm} from "@/modules/movement/service/IMovementForm"
import {ITransferForm} from "@/modules/movement/service/ITransferForm"
import {IFutureExpenseForm} from "@/modules/future-expense/service/IFutureExpenseForm"
import {PayReceiveModel} from "@/modules/pay-receive/model/PayReceiveModel"
import {ICardForm} from "@/modules/credit-cards/service/ICardForm"
import router from "../../router"
import {CardInvoiceItemModel} from "@/modules/credit-cards/model/CardInvoiceItemModel"
import {UserModel} from "@/modules/user/model/UserModel"
import {MainSettingsModel} from "@/modules/setings/model/MainSettingsModel"
import {IRegisterForm} from "@/modules/register/service/IRegisterForm"
import {MfpSubscriptionService} from "@/modules/subscription/service/MfpSubscriptionService"
import {ResponseListDefault} from "@/infra/response/response.list.default"

const baseApiUrl: string = process.env.VITE_API_BASE_URL ?? ''

function mountApiUrl(uri: string, id: null | number = null): string {
    const url: string = `${baseApiUrl}${uri}`
    return id ? `${url}/${id}` : url
}

function makeHeaders(): object {
    return {
        headers: {
            'content-type': 'application/json',
            'Accept': 'application/json',
            'X-MFP-USER-TOKEN': `Bearer ${AuthService.getToken()}`,
            'MFP-TOKEN': process.env.VITE_MFP_TOKEN,
        }
    }
}

function makeHeadersNonLogged(): object {
    return {
        headers: {
            'content-type': 'application/json',
            'Accept': 'application/json',
            'MFP-TOKEN': process.env.VITE_MFP_TOKEN,
        }
    }
}

axios.interceptors.response.use(response => {
    return response
}, async (error) => {
    if (error.response && error.response.status === 401) {
        await AuthService.logout()
        await router.push({ name: 'login' }).then(() => {
            window.location.reload();
        });
    }
    if (error.response && (error.response.status === 400 || error.response.status === 403)) {
        if (error.response.data.message.includes('atingido para o seu plano')) {
            await MfpSubscriptionService.openModal(error.response.data.message)
        } else {
            const okAlert: MfpOkAlert = new MfpOkAlert("Ocorreu um erro!")
            await okAlert.open(error.response.data.message)
        }
    }
    if (error.response && error.response.status === 503) {
        await router.push({name: 'updating'})
    }
    return Promise.reject(error)
})

export const ApiRouter = {
    auth: {
        login: async function (data: ILoginForm) {
            const response = await axios.post('/auth', data)
            return response.data
        },
        logout: async function () {
            return await axios.get('/logout')
        }
    },
    wallet: {
        index: async () => {
            const response = await axios.get(mountApiUrl('wallet'), makeHeaders())
            return response.data
        },
        post: async (data: IWalletForm) => {
            const response = await axios.post(mountApiUrl('wallet'), data, makeHeaders())
            return response.data
        },
        put: async (id: number, data: IWalletForm) => {
            const response = await axios.put(mountApiUrl('wallet', id), data, makeHeaders())
            return response.data
        },
        delete: async (id: number) => {
            const response = await axios.delete(mountApiUrl('wallet', id), makeHeaders())
            return response.data
        }
    },
    movement: {
        index: async () => {
            const response = await axios.get(mountApiUrl('movement'), makeHeaders())
            return response.data
        },
        indexFiltered: async (quest: null | string = null) => {
            quest = quest ? `?${quest}` : ''
            const response = await axios.get(mountApiUrl(`movement/filter${quest}`), makeHeaders())
            return response.data
        },
        post: async (data: IMovementForm) => {
            const response = await axios.post(mountApiUrl('movement'), data, makeHeaders())
            return response.data
        },
        put: async (id: number, data: IMovementForm) => {
            const response = await axios.put(mountApiUrl('movement', id), data, makeHeaders())
            return response.data
        },
        delete: async (id: number) => {
            const response = await axios.delete(mountApiUrl('movement', id), makeHeaders())
            return response.data
        },
        transfer: {
            post: async (data: ITransferForm) => {
                const response = await axios.post(mountApiUrl('movement/transfer'), data, makeHeaders())
                return response.data
            },
            delete: async (id: number) => {
                const response = await axios.delete(mountApiUrl('movement/transfer', id), makeHeaders())
                return response.data
            }
        }
    },
    panorama: {
        index: async () => {
            const response = await axios.get(mountApiUrl('panorama'), makeHeaders())
            return response.data
        }
    },
    futureExpense: {
        post: async (data: IFutureExpenseForm) => {
            const response = await axios.post(mountApiUrl('future-spent'), data, makeHeaders())
            return response.data
        },
        get: async (id: number) => {
            const response = await axios.get(mountApiUrl('future-spent', id), makeHeaders())
            return response.data
        },
        put: async (id: number, data: IFutureExpenseForm) => {
            const response = await axios.put(mountApiUrl('future-spent', id), data, makeHeaders())
            return response.data
        },
        delete: async (id: number) => {
            const response = await axios.delete(mountApiUrl('future-spent', id), makeHeaders())
            return response.data
        },
        pay: async (id: number, data: PayReceiveModel) => {
            const response = await axios.post(mountApiUrl(`future-spent/${id}/pay`), data, makeHeaders())
            return response.data
        }
    },
    futureProfits: {
        post: async (data: IFutureExpenseForm) => {
            const response = await axios.post(mountApiUrl('future-gain'), data, makeHeaders())
            return response.data
        },
        put: async (id: number, data: IFutureExpenseForm) => {
            const response = await axios.put(mountApiUrl('future-gain', id), data, makeHeaders())
            return response.data
        },
        get: async (id: number) => {
            const response = await axios.get(mountApiUrl('future-gain', id), makeHeaders())
            return response.data
        },
        delete: async (id: number) => {
            const response = await axios.delete(mountApiUrl('future-gain', id), makeHeaders())
            return response.data
        },
        receive: async (id: number, data: PayReceiveModel) => {
            const response = await axios.post(mountApiUrl(`future-gain/${id}/receive`), data, makeHeaders())
            return response.data
        }
    },
    cards: {
        index: async () => {
            const response = await axios.get(mountApiUrl('credit-card'), makeHeaders())
            return response.data
        },
        put: async (id: number, data: ICardForm) => {
            const response = await axios.put(mountApiUrl('credit-card', id), data, makeHeaders())
            return response.data
        },
        post: async (data: ICardForm) => {
            const response = await axios.post(mountApiUrl('credit-card'), data, makeHeaders())
            return response.data
        },
        delete: async (id: number) => {
            const response = await axios.delete(mountApiUrl('credit-card', id), makeHeaders())
            return response.data
        },
        payNextInvoice: async (data: ICardForm, walletId: number) => {
            const response = await axios.put(mountApiUrl(`credit-card/${data.id}/invoices/${walletId}`), null, makeHeaders())
            return response.data
        },
        invoices: {
            index: async (cardId: number | string) => {
                const response = await axios.get(mountApiUrl(`credit-card/${cardId}/invoices`), makeHeaders())
                return response.data
            },
            post: async (data: CardInvoiceItemModel) => {
                const response = await axios.post(mountApiUrl('credit-card/transaction'), data, makeHeaders())
                return response.data
            },
            put: async (cardId: number | string, data: CardInvoiceItemModel) => {
                const response = await axios.put(mountApiUrl(`credit-card/transaction/${cardId}`), data, makeHeaders())
                return response.data
            },
            get: async (id: number) => {
                const response = await axios.get(mountApiUrl(`credit-card/transaction/${id}`), makeHeaders())
                return response.data
            },
            delete: async (id: number) => {
                const response = await axios.delete(mountApiUrl(`credit-card/transaction/${id}`), makeHeaders())
                return response.data
            }
        }
    },
    user: {
        get: async function (id: number) {
            const response = await axios.get(mountApiUrl('user', id), makeHeaders())
            return response.data
        },
        update: async function (id: number, user: UserModel) {
            const response = await axios.put(mountApiUrl('user', id), user, makeHeaders())
            return response.data
        },
        register: async function (user: IRegisterForm) {
            const response = await axios.post('/user/register', user)
            return response.data
        },
        activateAccount: async function (hash: string) {
            const response = await axios.post(`/api/mfp/user/register/activate/${hash}`, {}, makeHeadersNonLogged())
            return response.data
        }
    },
    financialHealth: {
        getFiltered: async (quest: null | string = null) => {
            quest = quest ? `?${quest}` : ''
            const response = await axios.get(mountApiUrl(`financial-health/filter${quest}`), makeHeaders())
            return response.data
        }
    },
    settings: {
        index: async function () {
            const response = await axios.get(mountApiUrl('configurations'), makeHeaders())
            return response.data
        },
        update: async function (settings: Array<MainSettingsModel>) {
            const response = await axios.put(mountApiUrl('configurations'), settings, makeHeaders())
            return response.data
        }
    },
    subscription: {
        subscribe: async function () {
            const response = await axios.post(mountApiUrl('subscription/subscribe'), [], makeHeaders())
            return response.data
        },
        cancel: async function (data: any) {
            const response = await axios.post(mountApiUrl('subscription/cancel'), data, makeHeaders())
            return response.data
        }
    },
    marketPlanner: {
        showDetails: async function () {
            const response = await axios.get(mountApiUrl('v2/market-planner/show-details'), makeHeaders())
            return response.data
        }
    },
    earning_plan: {
        index: async function (): Promise<ResponseListDefault> {
            const data = await axios.get(mountApiUrl('v2/earnings-plan'), makeHeaders())
            return data.data
        }
    },
    genericListRequestWithAuth: async function (url: string): Promise<ResponseListDefault> {
        const data = await axios.get(url, makeHeaders())
        return data.data
    }
}
