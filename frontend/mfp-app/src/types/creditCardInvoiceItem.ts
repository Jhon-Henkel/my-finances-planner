import { z } from 'zod';

export const CreditCardInvoiceItemSchema = z.object({
    id: z.number().optional(),
    credit_card_invoice_id: z.number(),
    name: z.string(),
    value: z.number(),
    date: z.string().refine((val) => !isNaN(Date.parse(val)), {
        message: "Invalid date format",
    }),
    is_fixed: z.boolean(),
    installments: z.number(),
});

export type CreditCardInvoiceItem = z.infer<typeof CreditCardInvoiceItemSchema>;
