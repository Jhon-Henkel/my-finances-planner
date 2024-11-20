import Cookies from "js-cookie"

export const UtilCookies = {
    setCookie(name: string, value: string, expires: number): void {
        Cookies.set(name, value, {expires: expires})
    },
    getCookie(name: string): string | undefined {
        return Cookies.get(name)
    },
    setCookieObject(name: string, value: string, expires: number): void {
        Cookies.set(name, JSON.stringify(value), {expires: expires})
    },
    getCookieObject(name: string): string | undefined {
        const cookieValue = Cookies.get(name)
        return cookieValue ? JSON.parse(cookieValue) : undefined
    },
    removeCookie(name: string): void {
        Cookies.remove(name)
    }
}
