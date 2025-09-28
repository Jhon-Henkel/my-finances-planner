<?php

namespace App\Infra\Enum;

enum RouteNameEnum: string
{
    case ApiV3WalletCreate = 'api.v3.wallet.create';
    case ApiV3WalletList = 'api.v3.wallet.list';
    case ApiV3WalletGet = 'api.v3.wallet.get';
    case ApiV3WalletDelete = 'api.v3.wallet.delete';
    case ApiV3WalletUpdate = 'api.v3.wallet.update';

    case ApiV3CreditCardCreate = 'api.v3.credit-card.create';
    case ApiV3CreditCardList = 'api.v3.credit-card.list';
    case ApiV3CreditCardGet = 'api.v3.credit-card.get';
    case ApiV3CreditCardDelete = 'api.v3.credit-card.delete';
    case ApiV3CreditCardUpdate = 'api.v3.credit-card.update';

    case ApiV3MovementCreate = 'api.v3.movement.create';
    case ApiV3MovementList = 'api.v3.movement.list';
    case ApiV3MovementGet = 'api.v3.movement.get';
    case ApiV3MovementDelete = 'api.v3.movement.delete';
    case ApiV3MovementUpdate = 'api.v3.movement.update';
    case ApiV3MovementTransferCreate = 'api.v3.movement.transfer.create';
    case ApiV3MovementTransferDelete = 'api.v3.movement.transfer.delete';

    case ApiV3SpendingPlanCreate = 'api.v3.spending-plan.create';
    case ApiV3SpendingPlanList = 'api.v3.spending-plan.list';
    case ApiV3SpendingPlanGet = 'api.v3.spending-plan.get';
    case ApiV3SpendingPlanDelete = 'api.v3.spending-plan.delete';
    case ApiV3SpendingPlanUpdate = 'api.v3.spending-plan.update';
    case ApiV3SpendingPlanPay = 'api.v3.spending-plan.pay';

    case ApiV3EarningPlanCreate = 'api.v3.earning-plan.create';
    case ApiV3EarningPlanList = 'api.v3.earning-plan.list';
    case ApiV3EarningPlanGet = 'api.v3.earning-plan.get';
    case ApiV3EarningPlanDelete = 'api.v3.earning-plan.delete';
    case ApiV3EarningPlanUpdate = 'api.v3.earning-plan.update';
    case ApiV3EarningPlanReceive = 'api.v3.earning-plan.receive';

    case ApiV3AuthLogin = 'api.v3.auth.login';
}
