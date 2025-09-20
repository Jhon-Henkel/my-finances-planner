import { z } from 'zod';

export const CreditCardSchema = z.object({
    id: z.number().optional(),
    name: z.string(),
    limit: z.number(),
    due_day: z.number(),
    closing_day: z.number(),
});

export type CreditCard = z.infer<typeof CreditCardSchema>;
