import { defineStore } from 'pinia';
import MarketPlannerService from '../services/marketPlanner';
import { MarketPlanner } from '../types/marketPlanner';

export const useMarketPlannerStore = defineStore('marketPlanner', {
    state: () => ({
        marketPlanner: null as MarketPlanner | null,
    }),
    actions: {
        async fetchMarketPlanner() {
            const response = await MarketPlannerService.get();
            this.marketPlanner = response.data.data;
        },
    },
});
