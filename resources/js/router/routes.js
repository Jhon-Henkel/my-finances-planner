import { userAuthStore } from "../../vue/store/auth";

export default async function routesControl(to, from, next) {
    if (to.meta?.auth) {
        const auth = userAuthStore()
        if (auth.token && auth.user) {
            const isAuthenticated = await auth.checkToken()
            const isLogged = auth.isAuthUser()
            if (isAuthenticated && isLogged) {
                next()
            } else {
                next({ name: 'login' })
            }
        } else {
            next({ name: 'login' })
        }
    } else {
        next()
    }
}