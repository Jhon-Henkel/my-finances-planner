import axios from 'axios';
import { EarningPlan } from '../types/earningPlan';

const API_URL = '/api/v3/earning-plan';

class EarningPlanService {
    getAll() {
        return axios.get(API_URL);
    }

    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }

    create(earningPlan: EarningPlan) {
        return axios.post(API_URL, earningPlan);
    }

    update(earningPlan: EarningPlan) {
        return axios.put(`${API_URL}/${earningPlan.id}`, earningPlan);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }

    receive(id: number) {
        return axios.post(`${API_URL}/receive`, { id });
    }
}

export default new EarningPlanService();
