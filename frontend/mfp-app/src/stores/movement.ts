import { defineStore } from 'pinia';
import MovementService from '../services/movement';
import { Movement } from '../types/movement';

export const useMovementStore = defineStore('movement', {
    state: () => ({
        movements: [] as Movement[],
    }),
    actions: {
        async fetchMovements() {
            const response = await MovementService.getAll();
            this.movements = response.data.data;
        },
        async createMovement(movement: Movement) {
            await MovementService.create(movement);
            await this.fetchMovements();
        },
        async updateMovement(movement: Movement) {
            await MovementService.update(movement);
            await this.fetchMovements();
        },
        async deleteMovement(id: number) {
            await MovementService.delete(id);
            await this.fetchMovements();
        },
    },
});
