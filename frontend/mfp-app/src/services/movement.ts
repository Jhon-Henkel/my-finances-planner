import axios from 'axios';
import { Movement } from '../types/movement';

const API_URL = '/api/v3/movement';

class MovementService {
    getAll() {
        return axios.get(API_URL);
    }

    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }

    create(movement: Movement) {
        return axios.post(API_URL, movement);
    }

    update(movement: Movement) {
        return axios.put(`${API_URL}/${movement.id}`, movement);
    }

    delete(id: number) {
        return axios.delete(`${API_URL}/${id}`);
    }
}

export default new MovementService();
