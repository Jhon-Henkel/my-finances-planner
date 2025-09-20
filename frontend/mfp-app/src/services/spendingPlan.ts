import axios from 'axios';
import { SpendingPlan } from '../types/spendingPlan';

const API_URL = '/api/v3/spending-plan';

class SpendingPlanService {
    getAll() {
        return axios.get(API_URL);
    }

    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }

    create(spendingPlan: SpendingPlan) {
        return axios.post(API_URL, spendingPlan);
    }

    update(spendingPlan: SpendingPlan) {
        return axios.put(`${API_URL}/${spendingPlan.id}`, spendingPlan);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }

    pay(id: number) {
        return axios.post(`${API_URL}/pay`, { id });
    }
}

export default new SpendingPlanService();
