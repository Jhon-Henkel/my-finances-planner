import { z } from 'zod';

export const WalletSchema = z.object({
    id: z.number().optional(),
    name: z.string(),
    amount: z.number(),
});

export type Wallet = z.infer<typeof WalletSchema>;
