import {useAuthStore} from "@/stores/auth/AuthStore"

export default async function RouterAuthMiddleware(to: any, from: any, next: any): Promise<void> {
    try {
        if (to.meta?.auth) {
            const auth = useAuthStore()
            if (auth.token && auth.user) {
                if (auth.isAuthUser()) {
                    next()
                } else {
                    auth.logout()
                    next({ name: 'login', query: { redirect: to.name } }).then(() => {
                        window.location.reload();
                    });
                }
            } else {
                auth.logout()
                next({ name: 'login', query: { redirect: to.name } }).then(() => {
                    window.location.reload();
                });            }
        } else {
            next()
        }
    } catch (error) {
        next({ name: 'login', query: { redirect: to.name } }).then(() => {
            window.location.reload();
        });
    }
}
