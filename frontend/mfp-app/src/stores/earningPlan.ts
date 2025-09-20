import { defineStore } from 'pinia';
import EarningPlanService from '../services/earningPlan';
import { EarningPlan } from '../types/earningPlan';

export const useEarningPlanStore = defineStore('earningPlan', {
    state: () => ({
        earningPlans: [] as EarningPlan[],
    }),
    actions: {
        async fetchEarningPlans() {
            const response = await EarningPlanService.getAll();
            this.earningPlans = response.data.data;
        },
        async createEarningPlan(earningPlan: EarningPlan) {
            await EarningPlanService.create(earningPlan);
            await this.fetchEarningPlans();
        },
        async updateEarningPlan(earningPlan: EarningPlan) {
            await EarningPlanService.update(earningPlan);
            await this.fetchEarningPlans();
        },
        async deleteEarningPlan(id: number) {
            await EarningPlanService.delete(id);
            await this.fetchEarningPlans();
        },
        async receiveEarningPlan(id: number) {
            await EarningPlanService.receive(id);
            await this.fetchEarningPlans();
        },
    },
});
