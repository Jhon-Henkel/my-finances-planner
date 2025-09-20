import axios from 'axios';

const API_URL = '/api/v3/auth';

class AuthService {
    login(user) {
        return axios
            .post(API_URL + '/login', {
                email: user.email,
                password: user.password
            })
            .then(response => {
                if (response.data.token) {
                    localStorage.setItem('user', JSON.stringify(response.data));
                }

                return response.data;
            });
    }

    logout() {
        localStorage.removeItem('user');
    }

    register(user) {
        // Note: The API does not have a register endpoint in v3, so this is a placeholder
        return axios.post(API_URL + '/signup', {
            username: user.username,
            email: user.email,
            password: user.password
        });
    }
}

export default new AuthService();
