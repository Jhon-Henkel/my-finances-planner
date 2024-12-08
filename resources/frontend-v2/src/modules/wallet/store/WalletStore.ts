import { defineStore } from 'pinia'
import {WalletModel} from "@/modules/wallet/model/WalletModel"
import {WalletService} from "@/modules/wallet/service/WalletService"

interface IStateWallet {
    wallets: Array<WalletModel>,
    hiddenWallets: Array<WalletModel>,
    notHiddenWallets: Array<WalletModel>,
    isLoaded: boolean,
    totalAmount: number,
    totalAmountHidden: number
}

export const useWalletStore = defineStore({
    id: 'wallet',
    state: (): IStateWallet => ({
        wallets: [],
        hiddenWallets: [],
        notHiddenWallets: [],
        isLoaded: false,
        totalAmount: 0,
        totalAmountHidden: 0
    }),
    actions: {
        loadAgainOnNextTick() {
            this.isLoaded = false
            this.totalAmount = 0
        }
    },
    getters: {
        async getWallets(): Promise<Array<WalletModel>> {
            if (!this.isLoaded) {
                this.isLoaded = false
                this.wallets = await WalletService.index()
                this.hiddenWallets = []
                this.notHiddenWallets = []
                for (let i = 0; i < this.wallets.length; i++) {
                    if (this.wallets[i].hideValue) {
                        this.hiddenWallets.push(this.wallets[i])
                        this.totalAmountHidden += this.wallets[i].amount
                    } else {
                        this.notHiddenWallets.push(this.wallets[i])
                    }
                }
                this.isLoaded = true
            }
            return this.wallets
        },
        isLoadedOnStore(): boolean {
            return this.isLoaded
        },
        getTotalAmount(): number {
            if (this.totalAmount == 0) {
                this.totalAmount = WalletService.sumTotalBalance(this.wallets)
            }
            return this.totalAmount
        }
    }
})
