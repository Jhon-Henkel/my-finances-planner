import axios from 'axios';

const API_URL = '/api/v3/market-planner';

class MarketPlannerService {
    get() {
        return axios.get(API_URL);
    }
}

export default new MarketPlannerService();
