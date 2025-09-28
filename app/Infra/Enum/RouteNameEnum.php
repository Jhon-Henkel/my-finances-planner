<?php

namespace App\Infra\Enum;

enum RouteNameEnum: string
{
    case ApiV3WalletList = 'api.v3.wallet.list';
    case ApiV3WalletGet = 'api.v3.wallet.get';
    case ApiV3WalletCreate = 'api.v3.wallet.create';
    case ApiV3WalletUpdate = 'api.v3.wallet.update';
    case ApiV3WalletDelete = 'api.v3.wallet.delete';

    case ApiV3CreditCardList = 'api.v3.credit-card.list';
    case ApiV3CreditCardGet = 'api.v3.credit-card.get';
    case ApiV3CreditCardCreate = 'api.v3.credit-card.create';
    case ApiV3CreditCardUpdate = 'api.v3.credit-card.update';
    case ApiV3CreditCardDelete = 'api.v3.credit-card.delete';

    case ApiV3MovementList = 'api.v3.movement.list';
    case ApiV3MovementGet = 'api.v3.movement.get';
    case ApiV3MovementCreate = 'api.v3.movement.create';
    case ApiV3MovementUpdate = 'api.v3.movement.update';
    case ApiV3MovementDelete = 'api.v3.movement.delete';

    case ApiV3MovementTransferCreate = 'api.v3.movement.transfer.create';
    case ApiV3MovementTransferDelete = 'api.v3.movement.transfer.delete';

    case ApiV3AuthLogin = 'api.v3.auth.login';

    case ApiV3FinancialPlanList = 'api.v3.financial-plan.list';
    case ApiV3FinancialPlanGet = 'api.v3.financial-plan.get';
    case ApiV3FinancialPlanCreate = 'api.v3.financial-plan.create';
    case ApiV3FinancialPlanUpdate = 'api.v3.financial-plan.update';
    case ApiV3FinancialPlanDelete = 'api.v3.financial-plan.delete';
}
