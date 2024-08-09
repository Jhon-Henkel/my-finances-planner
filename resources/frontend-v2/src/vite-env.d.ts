/// <reference types="vite/client" />
interface ImportMetaEnv {
    readonly VITE_ENV: string;
    readonly VITE_PUBLIC_STORAGE_BASE_URL: string;
    readonly VITE_API_BASE_URL: string;
    readonly VITE_MFP_TOKEN: string;
    readonly VITE_SENTRY_DSN_PUBLIC: string;
}

interface ImportMeta {
    readonly env: ImportMetaEnv;
}
