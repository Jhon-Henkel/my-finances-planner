import { defineStore } from 'pinia';
import ConfigurationService from '../services/configuration';
import { Configuration } from '../types/configuration';

export const useConfigurationStore = defineStore('configuration', {
    state: () => ({
        configurations: [] as Configuration[],
    }),
    actions: {
        async fetchConfigurations() {
            const response = await ConfigurationService.getAll();
            this.configurations = response.data.data;
        },
    },
});
