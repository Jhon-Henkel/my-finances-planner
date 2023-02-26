<?php

namespace App\Enums;

class RouteEnum
{
    const NAME = 'as';
    const METHOD = 'uses';
    const API_WALLET_INDEX = 'apiWalletIndex';
    const API_WALLET_INDEX_METHOD = 'WalletController@index';
    const API_WALLET_SHOW = 'apiWalletShow';
    const API_WALLET_SHOW_METHOD = 'WalletController@show';
    const API_WALLET_INSERT = 'apiWalletInsert';
    const API_WALLET_INSERT_METHOD = 'WalletController@insert';
    const API_WALLET_UPDATE = 'apiWalletUpdate';
    const API_WALLET_UPDATE_METHOD = 'WalletController@update';
    const API_WALLET_DELETE = 'apiWalletDelete';
    const API_WALLET_DELETE_METHOD = 'WalletController@delete';

    public static function getRouteParams(string $routeName): array
    {
        return match ($routeName) {
            'apiWalletIndex' => array(
                self::NAME => self::API_WALLET_INDEX,
                self::METHOD => self::API_WALLET_INDEX_METHOD
            ),
            'apiWalletShow' => array(
                self::NAME => self::API_WALLET_SHOW,
                self::METHOD => self::API_WALLET_SHOW_METHOD
            ),
            'apiWalletInsert' => array(
                self::NAME => self::API_WALLET_INSERT,
                self::METHOD => self::API_WALLET_INSERT_METHOD
            ),
            'apiWalletUpdate' => array(
                self::NAME => self::API_WALLET_UPDATE,
                self::METHOD => self::API_WALLET_UPDATE_METHOD
            ),
            'apiWalletDelete' => array(
                self::NAME => self::API_WALLET_DELETE,
                self::METHOD => self::API_WALLET_DELETE_METHOD
            ),
        };
    }
}
