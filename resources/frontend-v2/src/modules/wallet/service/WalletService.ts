import {ApiRouter} from "@/infra/requst/api/ApiRouter"
import {WalletModel} from "@/modules/wallet/model/WalletModel"
import {IWalletForm} from "@/modules/wallet/service/IWalletForm"
import {useWalletStore} from "@/modules/wallet/store/WalletStore"

export const WalletService = {
    index: async (): Promise<Array<WalletModel>> => {
        const data = await ApiRouter.wallet.index()
        return data.map((item: any) => new WalletModel(item))
    },
    create: async (data: IWalletForm): Promise<WalletModel> => {
        return await ApiRouter.wallet.post(data).then((response: any) => {
            return new WalletModel(response)
        })
    },
    update: async (data: IWalletForm): Promise<WalletModel> => {
        return await ApiRouter.wallet.put(data.id, data).then((response: any) => {
            return new WalletModel(response)
        })
    },
    delete: async (id: number): Promise<void> => {
        await ApiRouter.wallet.delete(id)
    },
    emptyWallet: () :IWalletForm  => {
        return {
            id: undefined,
            name: '',
            amount: 0,
            hideValue: false
        }
    },
    sumTotalBalance: (accounts: Array<WalletModel>): number => {
        let total: number = 0
        if (accounts.length > 0) {
            accounts.forEach((account: WalletModel) => {
                if (!account.hideValue) {
                    total += parseFloat(String(account.amount))
                }
            })
        }
        return parseFloat(total.toFixed(2))
    },
    updateWalletList: async () => {
        const store= useWalletStore()
        if (! store.isLoaded) {
            await store.getWallets
        }
    },
    forceUpdateWalletList: async () => {
        const store= useWalletStore()
        store.loadAgainOnNextTick()
        if (! store.isLoaded) {
            await store.getWallets
        }
    }
}
