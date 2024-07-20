export const UtilApp = {
    isAppInDevelopmentMode: () => {
        return process.env.VITE_MFP_APP_DEMO_MODE === 'true';
    },
    isDevelopmentMode: () => {
        return process.env.VITE_ENV === 'develop';
    }
}