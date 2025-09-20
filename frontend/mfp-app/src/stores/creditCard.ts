import { defineStore } from 'pinia';
import CreditCardService from '../services/creditCard';
import { CreditCard } from '../types/creditCard';

export const useCreditCardStore = defineStore('creditCard', {
    state: () => ({
        creditCards: [] as CreditCard[],
    }),
    actions: {
        async fetchCreditCards() {
            const response = await CreditCardService.getAll();
            this.creditCards = response.data.data;
        },
        async createCreditCard(creditCard: CreditCard) {
            await CreditCardService.create(creditCard);
            await this.fetchCreditCards();
        },
        async updateCreditCard(creditCard: CreditCard) {
            await CreditCardService.update(creditCard);
            await this.fetchCreditCards();
        },
        async deleteCreditCard(id: number) {
            await CreditCardService.delete(id);
            await this.fetchCreditCards();
        },
    },
});
