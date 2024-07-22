export const UtilApp = {
    isAppInDemoMode: () => {
        return process.env.VITE_MFP_APP_DEMO_MODE === 'true';
    },
    isAppInDeveloperMode: () => {
        return process.env.VITE_ENV === 'develop';
    }
}