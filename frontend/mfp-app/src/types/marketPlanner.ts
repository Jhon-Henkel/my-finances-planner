import { z } from 'zod';

export const MarketPlannerSchema = z.object({
    use_market_planner: z.boolean(),
    total_limit: z.number(),
    this_month_spent: z.number(),
    this_month_remaining_limit: z.number(),
});

export type MarketPlanner = z.infer<typeof MarketPlannerSchema>;
