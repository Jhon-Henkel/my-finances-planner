import axios from "axios"
import {ILoginForm} from "@/services/auth/ILoginForm"
import {AuthService} from "@/services/auth/AuthService"
import {IWalletForm} from "@/services/wallet/IWalletForm"
import {MfpOkAlert} from "@/components/alert/MfpOkAlert"
import {IMovementForm} from "@/services/movement/IMovementForm"
import {ITransferForm} from "@/services/movement/transfer/ITransferForm"
import {IFutureExpenseForm} from "@/services/future-expense/IFutureExpenseForm"
import {PayReceiveModel} from "@/model/pay-receive/PayReceiveModel"
import {ICardForm} from "@/services/cards/ICardForm"

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

axios.interceptors.response.use(response => {
    return response
}, async (error) => {
    if (error.response && error.response.status === 401) {
        await AuthService.logout()
    }
    if (error.response && error.response.status === 400) {
        const okAlert: MfpOkAlert = new MfpOkAlert("Ocorreu um erro!")
        await okAlert.open(error.response.data.message)
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
        index: async () => {
            const response = await axios.get(mountApiUrl('future-gain/next-six-months'), makeHeaders())
            return response.data
        },
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
        }
    }
}