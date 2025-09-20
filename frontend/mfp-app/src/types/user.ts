import { z } from 'zod';

export const UserSchema = z.object({
    id: z.number(),
    name: z.string(),
    email: z.string().email(),
    status: z.number(),
    email_verified_at: z.string().nullable(),
    created_at: z.string(),
    updated_at: z.string(),
});

export type User = z.infer<typeof UserSchema>;
