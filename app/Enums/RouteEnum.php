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
    const WEB_LOGIN = 'login';
    const WEB_LOGOUT = 'logout';
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
}