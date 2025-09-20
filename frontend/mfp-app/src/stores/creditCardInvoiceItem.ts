import { defineStore } from 'pinia';
import CreditCardInvoiceItemService from '../services/creditCardInvoiceItem';
import { CreditCardInvoiceItem } from '../types/creditCardInvoiceItem';
import { useCreditCardInvoiceStore } from './creditCardInvoice';

export const useCreditCardInvoiceItemStore = defineStore('creditCardInvoiceItem', {
    state: () => ({
        creditCardInvoiceItems: [] as CreditCardInvoiceItem[],
    }),
    actions: {
        async createCreditCardInvoiceWithItem(data: any) {
            await CreditCardInvoiceItemService.createWithInvoice(data);
        },
        async createCreditCardInvoiceItem(creditCardInvoiceItem: CreditCardInvoiceItem) {
            await CreditCardInvoiceItemService.create(creditCardInvoiceItem);
        },
        async updateCreditCardInvoiceItem(creditCardInvoiceItem: CreditCardInvoiceItem) {
            await CreditCardInvoiceItemService.update(creditCardInvoiceItem);
        },
        async deleteCreditCardInvoiceItem(id: number) {
            await CreditCardInvoiceItemService.delete(id);
        },
    },
});
