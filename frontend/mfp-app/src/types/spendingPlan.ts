import { z } from 'zod';

export const SpendingPlanSchema = z.object({
    id: z.number().optional(),
    name: z.string(),
    amount: z.number(),
    isFixed: z.boolean(),
    installments: z.number(),
    recurrence: z.number(),
    dueDate: z.string().refine((val) => !isNaN(Date.parse(val)), {
        message: "Invalid date format",
    }),
    bankSlipCode: z.string().nullable().optional(),
});

export type SpendingPlan = z.infer<typeof SpendingPlanSchema>;
