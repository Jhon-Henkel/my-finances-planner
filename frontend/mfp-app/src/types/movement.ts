import { z } from 'zod';

export const MovementSchema = z.object({
    id: z.number().optional(),
    walletId: z.number(),
    description: z.string(),
    type: z.enum(['5', '6', '7']),
    amount: z.number(),
});

export type Movement = z.infer<typeof MovementSchema>;
