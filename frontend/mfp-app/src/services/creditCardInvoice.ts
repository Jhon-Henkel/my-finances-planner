import axios from 'axios';
import { CreditCardInvoice } from '../types/creditCardInvoice';

const API_URL = '/api/v3/credit-card-invoice';

class CreditCardInvoiceService {
    getAll() {
        return axios.get(API_URL);
    }

    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }

    create(creditCardInvoice: CreditCardInvoice) {
        return axios.post(API_URL, creditCardInvoice);
    }

    update(creditCardInvoice: CreditCardInvoice) {
        return axios.put(`${API_URL}/${creditCardInvoice.id}`, creditCardInvoice);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }
}

export default new CreditCardInvoiceService();
