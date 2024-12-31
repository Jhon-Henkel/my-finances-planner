import type {CapacitorConfig} from '@capacitor/cli'

const config: CapacitorConfig = {
    appId: 'financesinhands.app',
    appName: 'financas-na-mao',
    webDir: '../../public/build-ionic',
    server: {
        cleartext: true
    }
}

export default config
