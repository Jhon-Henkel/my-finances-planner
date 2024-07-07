/// <reference types="vite/client" />
interface ImportMetaEnv {
    readonly VITE_ENV: string;
    readonly VITE_PUBLIC_STORAGE_BASE_URL: string;
}

interface ImportMeta {
    readonly env: ImportMetaEnv;
}