import { z } from 'zod';

export const ConfigurationSchema = z.object({
    id: z.number(),
    name: z.string(),
    value: z.string(),
});

export type Configuration = z.infer<typeof ConfigurationSchema>;
