import { defineStore } from 'pinia';
import CreditCardInvoiceService from '../services/creditCardInvoice';
import { CreditCardInvoice } from '../types/creditCardInvoice';

export const useCreditCardInvoiceStore = defineStore('creditCardInvoice', {
    state: () => ({
        creditCardInvoices: [] as CreditCardInvoice[],
    }),
    actions: {
        async fetchCreditCardInvoices() {
            const response = await CreditCardInvoiceService.getAll();
            this.creditCardInvoices = response.data.data;
        },
        async createCreditCardInvoice(creditCardInvoice: CreditCardInvoice) {
            await CreditCardInvoiceService.create(creditCardInvoice);
            await this.fetchCreditCardInvoices();
        },
        async updateCreditCardInvoice(creditCardInvoice: CreditCardInvoice) {
            await CreditCardInvoiceService.update(creditCardInvoice);
            await this.fetchCreditCardInvoices();
        },
        async deleteCreditCardInvoice(id: number) {
            await CreditCardInvoiceService.delete(id);
            await this.fetchCreditCardInvoices();
        },
    },
});
