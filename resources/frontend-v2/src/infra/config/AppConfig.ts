class AppConfig {
    static storageBaseUrl: string = process.env.VITE_PUBLIC_STORAGE_BASE_URL ?? '';
}

export default AppConfig;