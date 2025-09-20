import axios from 'axios';
import { CreditCardInvoiceItem } from '../types/creditCardInvoiceItem';

const API_URL = '/api/v3/credit-card-invoice-item';

class CreditCardInvoiceItemService {
    createWithInvoice(data: any) {
        return axios.post(API_URL, data);
    }

    create(creditCardInvoiceItem: CreditCardInvoiceItem) {
        return axios.post(API_URL, creditCardInvoiceItem);
    }

    update(creditCardInvoiceItem: CreditCardInvoiceItem) {
        return axios.put(`${API_URL}/${creditCardInvoiceItem.id}`, creditCardInvoiceItem);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }
}

export default new CreditCardInvoiceItemService();
