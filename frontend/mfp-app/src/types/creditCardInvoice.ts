import { z } from 'zod';
import { CreditCardInvoiceItemSchema } from './creditCardInvoiceItem';

export const CreditCardInvoiceSchema = z.object({
    id: z.number().optional(),
    credit_card_id: z.number(),
    name: z.string(),
    due_date: z.string().refine((val) => !isNaN(Date.parse(val)), {
        message: "Invalid date format",
    }),
    closing_date: z.string().refine((val) => !isNaN(Date.parse(val)), {
        message: "Invalid date format",
    }),
    items: z.array(CreditCardInvoiceItemSchema).optional(),
});

export type CreditCardInvoice = z.infer<typeof CreditCardInvoiceSchema>;
