import axios from "axios"
import {ILoginForm} from "@/services/auth/ILoginForm"

export const ApiRouter = {
    auth: {
        login: async function (data: ILoginForm) {
            const response = await axios.post('/auth', data)
            return response.data
        },
        logout: async function () {
            return await axios.get('/logout')
        }
    }
}