export const UtilApp = {
    isAppInDeveloperMode: () => {
        return process.env.VITE_ENV === 'develop';
    }
}
