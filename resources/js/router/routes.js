import { userAuthStore } from '../../vue/store/auth'

export default async function routesControl(to, from, next) {
    try {
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
    } catch (error) {
        next({ name: 'login' })
    }
}