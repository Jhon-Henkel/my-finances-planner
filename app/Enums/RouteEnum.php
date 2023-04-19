<?php

namespace App\Enums;

class RouteEnum
{
    const API_WALLET_INDEX = 'apiWalletIndex';
    const API_WALLET_SHOW = 'apiWalletShow';
    const API_WALLET_SHOW_TYPE = 'apiWalletShowType';
    const API_WALLET_INSERT = 'apiWalletInsert';
    const API_WALLET_UPDATE = 'apiWalletUpdate';
    const API_WALLET_DELETE = 'apiWalletDelete';
    const API_MOVEMENT_INDEX = 'apiMovementIndex';
    const API_MOVEMENT_SHOW = 'apiMovementShow';
    const API_MOVEMENT_SHOW_TYPE = 'apiMovementShowType';
    const API_MOVEMENT_INSERT = 'apiMovementInsert';
    const API_MOVEMENT_UPDATE = 'apiMovementUpdate';
    const API_MOVEMENT_DELETE = 'apiMovementDelete';
    const API_CREDIT_CARD_INDEX = 'apiCreditCardIndex';
    const API_CREDIT_CARD_SHOW  = 'apiCreditCardShow';
    const API_CREDIT_CARD_INSERT = 'apiCreditCardInsert';
    const API_CREDIT_CARD_UPDATE = 'apiCreditCardUpdate';
    const API_CREDIT_CARD_DELETE = 'apiCreditCardDelete';
    const API_CREDIT_CARD_TRANSACTION_INDEX = 'apiCreditCardTransactionIndex';
    const API_CREDIT_CARD_TRANSACTION_SHOW = 'apiCreditCardTransactionShow';
    const API_CREDIT_CARD_TRANSACTION_INSERT = 'apiCreditCardTransactionInsert';
    const API_CREDIT_CARD_TRANSACTION_UPDATE = 'apiCreditCardTransactionUpdate';
    const API_CREDIT_CARD_TRANSACTION_DELETE = 'apiCreditCardTransactionDelete';
    const WEB_LOGIN = 'login';
    const WEB_LOGOUT = 'logout';
    const WEB_IS_USER_LOGGED = 'webIsUserLogged';
    const WEB_GET_MFP_TOKEN = 'getMfpToken';
    const WEB_MAKE_LOGIN = 'makeLogin';
    const WEB_DASHBOARD = 'dashboard';
    const WEB_WALLET = 'wallet';
    const WEB_NEW_WALLET = 'newWallet';
    const WEB_UPDATE_WALLET = 'updateWallet';
    const WEB_DELETE_WALLET = 'deleteWallet';
    const WEB_MOVEMENT = 'movement';
    const WEB_DELETE_MOVEMENT = 'deleteMovement';
    const WEB_INSERT_SPENT = 'insertSpent';
    const WEB_INSERT_GAIN = 'insertGain';
    const WEB_INSERT_TRANSFER = 'insertTransfer';
    const WEB_FUTURE_GAIN = 'futureGain';
}