import axios from 'axios';
import { Wallet } from '../types/wallet';

const API_URL = '/api/v3/wallet';

class WalletService {
    getAll() {
        return axios.get(API_URL);
    }

    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }

    create(wallet: Wallet) {
        return axios.post(API_URL, wallet);
    }

    update(wallet: Wallet) {
        return axios.put(`${API_URL}/${wallet.id}`, wallet);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }
}

export default new WalletService();
