import axios from 'axios';

const API_URL = '/api/v3/financial-health';

class FinancialHealthService {
    get() {
        return axios.get(API_URL);
    }
}

export default new FinancialHealthService();
