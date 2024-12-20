import {useAuthStore} from "@/modules/login/store/AuthStore"
import {RouteName} from "@/infra/router/routeName"

export default async function RouterAuthMiddleware(to: any, from: any, next: any): Promise<void> {
    try {
        if (to.meta?.auth) {
            const auth = useAuthStore()
            if (auth.token && auth.user) {
                if (auth.isAuthUser()) {
                    next()
                } else {
                    auth.logout()
                    next({ name: RouteName.login, query: { redirect: to.name } })
                }
            } else {
                auth.logout()
                next({ name: RouteName.login, query: { redirect: to.name } })
            }
        } else {
            next()
        }
    } catch (error) {
        next({ name: RouteName.login, query: { redirect: to.name } })
    }
}
