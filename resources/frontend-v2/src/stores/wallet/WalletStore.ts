import { defineStore } from 'pinia'
import {WalletModel} from "@/model/wallet/WalletModel"
import {WalletService} from "@/services/wallet/WalletService"

export const useWalletStore = defineStore({
    id: 'wallet',
    state: (): {wallets: Array<WalletModel>, isLoaded: boolean, totalAmount: number} => ({
        wallets: [],
        isLoaded: false,
        totalAmount: 0
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