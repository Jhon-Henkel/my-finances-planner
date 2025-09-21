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
}

export default new AuthService();
