import { defineStore } from 'pinia';
import SpendingPlanService from '../services/spendingPlan';
import { SpendingPlan } from '../types/spendingPlan';

export const useSpendingPlanStore = defineStore('spendingPlan', {
    state: () => ({
        spendingPlans: [] as SpendingPlan[],
    }),
    actions: {
        async fetchSpendingPlans() {
            const response = await SpendingPlanService.getAll();
            this.spendingPlans = response.data.data;
        },
        async createSpendingPlan(spendingPlan: SpendingPlan) {
            await SpendingPlanService.create(spendingPlan);
            await this.fetchSpendingPlans();
        },
        async updateSpendingPlan(spendingPlan: SpendingPlan) {
            await SpendingPlanService.update(spendingPlan);
            await this.fetchSpendingPlans();
        },
        async deleteSpendingPlan(id: number) {
            await SpendingPlanService.delete(id);
            await this.fetchSpendingPlans();
        },
        async paySpendingPlan(id: number) {
            await SpendingPlanService.pay(id);
            await this.fetchSpendingPlans();
        },
    },
});
