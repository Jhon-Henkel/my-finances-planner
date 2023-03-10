<?php

namespace App\Enums;

class RouteEnum
{
    const API_WALLET_INDEX = 'apiWalletIndex';
    const API_WALLET_INDEX_METHOD = 'WalletController@index';
    const API_WALLET_SHOW = 'apiWalletShow';
    const API_WALLET_SHOW_METHOD = 'WalletController@show';
    const API_WALLET_SHOW_TYPE = 'apiWalletShowType';
    const API_WALLET_SHOW_TYPE_METHOD = 'WalletController@showByType';
    const API_WALLET_INSERT = 'apiWalletInsert';
    const API_WALLET_INSERT_METHOD = 'WalletController@insert';
    const API_WALLET_UPDATE = 'apiWalletUpdate';
    const API_WALLET_UPDATE_METHOD = 'WalletController@update';
    const API_WALLET_DELETE = 'apiWalletDelete';
    const API_WALLET_DELETE_METHOD = 'WalletController@delete';
    const API_MOVEMENT_INDEX = 'apiMovementIndex';
    const API_MOVEMENT_INDEX_METHOD = 'MovementController@index';
    const API_MOVEMENT_SHOW = 'apiMovementShow';
    const API_MOVEMENT_SHOW_METHOD = 'MovementController@show';
    const API_MOVEMENT_SHOW_TYPE = 'apiMovementShowType';
    const API_MOVEMENT_SHOW_TYPE_METHOD = 'MovementController@showByType';
    const API_MOVEMENT_INSERT = 'apiMovementInsert';
    const API_MOVEMENT_INSERT_METHOD = 'MovementController@insert';
    const API_MOVEMENT_UPDATE = 'apiMovementUpdate';
    const API_MOVEMENT_UPDATE_METHOD = 'MovementController@update';
    const API_MOVEMENT_DELETE = 'apiMovementDelete';
    const API_MOVEMENT_DELETE_METHOD = 'MovementController@delete';
}