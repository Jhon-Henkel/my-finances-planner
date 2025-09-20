import { defineStore } from 'pinia';
import AuthService from '../services/auth';

const user = JSON.parse(localStorage.getItem('user'));

export const useAuthStore = defineStore('auth', {
    state: () => ({
        status: {
            loggedIn: user ? true : false,
        },
        user: user ? user : null,
    }),
    actions: {
        login(user) {
            return AuthService.login(user).then(
                response => {
                    this.status.loggedIn = true;
                    this.user = response.user;
                    return Promise.resolve(response);
                },
                error => {
                    this.status.loggedIn = false;
                    this.user = null;
                    return Promise.reject(error);
                }
            );
        },
        logout() {
            AuthService.logout();
            this.status.loggedIn = false;
            this.user = null;
        },
    },
});
