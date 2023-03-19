<?php

namespace App\Enums;

enum ViewEnum
{
    const VIEW_LOGIN = 'login';
    const VIEW_DASBOARD = 'dashboard';
    const VIEW_MOVEMENT = 'movement';
    const VIEW_WALLET = 'wallet';
    const VIEW_SIDEBAR = 'snippets.sidebar';
    const VIEW_NAVBAR = 'snippets.navbar';
    const VIEW_BASE = 'snippets.base';
    const VIEW_SPENT_MODAL = 'snippets.movement.insertSpentModal';
    const VIEW_GAIN_MODAL = 'snippets.movement.insertGainModal';
    const VIEW_TRANSFER_MODAL = 'snippets.movement.insertTransferModal';
    const VIEW_INSERT_WALLET_MODAL = 'snippets.wallet.insertWalletModal';
    const VIEW_UPDATE_WALLET_MODAL = 'snippets.wallet.updateWalletModal';
    const VIEW_HEADER_MODAL = 'snippets.modal.headerModal';
    const VIEW_DEFAULT_INPUT_MODAL = 'snippets.modal.formGroupInputModal';
    const VIEW_WALLET_TYPE_SELECT_MODAL = 'snippets.wallet.walletTypeSelect';
    const VIEW_AMOUNT_INPUT_MODAL = 'snippets.modal.amountInputModal';
    const VIEW_FOOTER_MODAL = 'snippets.modal.footerModal';
    const VIEW_MOVEMENT_TOP_BUTTONS = 'snippets.movement.topButtons';
    const VIEW_GAIN_SPENT_SELECT_MODAL = 'snippets.movement.insertGainSpentSelect';
}
