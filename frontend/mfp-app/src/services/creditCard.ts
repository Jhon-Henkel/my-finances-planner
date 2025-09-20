import axios from 'axios';
import { CreditCard } from '../types/creditCard';

const API_URL = '/api/v3/credit-card';

class CreditCardService {
    getAll() {
        return axios.get(API_URL);
    }

    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }

    create(creditCard: CreditCard) {
        return axios.post(API_URL, creditCard);
    }

    update(creditCard: CreditCard) {
        return axios.put(`${API_URL}/${creditCard.id}`, creditCard);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }
}

export default new CreditCardService();
