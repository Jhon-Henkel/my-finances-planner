import {ApiRouter} from "@/api/ApiRouter"
import {WalletModel} from "@/model/wallet/WalletModel"
import {IWalletForm} from "@/services/wallet/IWalletForm"

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
            amount: 0
        }
    },
    sumTotalBalance: (accounts: Array<WalletModel>): number => {
        let total: number = 0
        if (accounts.length > 0) {
            accounts.forEach((account: WalletModel) => {
                total += parseFloat(String(account.amount))
            })
        }
        return parseFloat(total.toFixed(2))
    }
}