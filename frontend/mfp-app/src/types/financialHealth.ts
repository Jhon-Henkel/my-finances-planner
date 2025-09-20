import { z } from 'zod';

export const FinancialHealthDataSchema = z.object({
    label: z.array(z.string()),
    data: z.array(z.number()),
    color: z.array(z.string()),
    total: z.number(),
});

export const FinancialHealthSchema = z.object({
    5: FinancialHealthDataSchema.optional(), // Spent
    6: FinancialHealthDataSchema.optional(), // Gain
    dataForGraph: z.object({
        5: FinancialHealthDataSchema.optional(), // Spent
        6: FinancialHealthDataSchema.optional(), // Gain
    }),
});

export type FinancialHealth = z.infer<typeof FinancialHealthSchema>;
export type FinancialHealthData = z.infer<typeof FinancialHealthDataSchema>;
