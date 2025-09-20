import { defineStore } from 'pinia';
import UserService from '../services/user';
import { User } from '../types/user';

export const useUserStore = defineStore('user', {
    state: () => ({
        user: null as User | null,
    }),
    actions: {
        async fetchUser(id: number) {
            const response = await UserService.getById(id);
            this.user = response.data.data;
        },
    },
});
