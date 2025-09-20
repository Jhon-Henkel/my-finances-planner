import { defineStore } from 'pinia';
import FinancialHealthService from '../services/financialHealth';
import { FinancialHealth } from '../types/financialHealth';

export const useFinancialHealthStore = defineStore('financialHealth', {
    state: () => ({
        financialHealth: null as FinancialHealth | null,
    }),
    actions: {
        async fetchFinancialHealth() {
            const response = await FinancialHealthService.get();
            this.financialHealth = response.data;
        },
    },
});
