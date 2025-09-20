import axios from 'axios';

const API_URL = '/api/v3/user';

class UserService {
    getById(id: number) {
        return axios.get(`${API_URL}/${id}`);
    }
}

export default new UserService();
