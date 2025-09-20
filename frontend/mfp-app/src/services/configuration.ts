import axios from 'axios';

const API_URL = '/api/v3/configurations';

class ConfigurationService {
    getAll() {
        return axios.get(API_URL);
    }
}

export default new ConfigurationService();
