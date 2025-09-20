import { defineStore } from 'pinia';
import WalletService from '../services/wallet';
import { Wallet } from '../types/wallet';

export const useWalletStore = defineStore('wallet', {
    state: () => ({
        wallets: [] as Wallet[],
    }),
    actions: {
        async fetchWallets() {
            const response = await WalletService.getAll();
            this.wallets = response.data.data;
        },
        async createWallet(wallet: Wallet) {
            await WalletService.create(wallet);
            await this.fetchWallets();
        },
        async updateWallet(wallet: Wallet) {
            await WalletService.update(wallet);
            await this.fetchWallets();
        },
        async deleteWallet(id: number) {
            await WalletService.delete(id);
            await this.fetchWallets();
        },
    },
});
