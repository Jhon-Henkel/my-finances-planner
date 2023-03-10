<?php

namespace App\Providers\Passport;

use Laravel\Lumen\Routing\Router;

class LumenRouteRegistrar
{
    private Router $router;
    private array $options;

    /**
     * Create a new route registrar instance.
     *
     * @param Router $router
     * @param array $options
     */
    public function __construct(Router $router, array $options = [])
    {
        $this->router = $router;
        $this->options = $options;
    }

    /**
     * Register routes for transient tokens, clients, and personal access tokens.
     *
     * @return void
     */
    public function all()
    {
        $this->forAccessTokens();
        $this->forTransientTokens();
        $this->forClients();
        $this->forPersonalAccessTokens();
    }

    /**
     * @param string $path
     * @return string
     */
    private function prefix(string $path): string
    {
        if (!str_contains($path, '\\') && isset($this->options['namespace'])) {
            return $this->options['namespace'] . '\\' . $path;
        }
        return $path;
    }

    /**
     * Register the routes for retrieving and issuing access tokens.
     *
     * @return void
     */
    public function forAccessTokens()
    {
        $this->router->post('/token', [
            'uses' => 'AccessTokenController@issueToken',
            'as' => 'passport.token',
        ]);
        $this->router->group(['middleware' => ['web', 'auth']], function ($router) {
            $router->get('/tokens', [
                'uses' => 'AuthorizedAccessTokenController@forUser',
                'as' => 'passport.tokens.index',
            ]);
            $router->delete('/tokens/{token_id}', [
                'uses' => 'AuthorizedAccessTokenController@destroy',
                'as' => 'passport.tokens.destroy',
            ]);
        });
    }

    /**
     * Register the routes needed for refreshing transient tokens.
     *
     * @return void
     */
    public function forTransientTokens()
    {
        $this->router->post('/token/refresh', [
            'middleware' => ['auth'],
            'uses' => $this->prefix('TransientTokenController@refresh')
        ]);
    }

    /**
     * Register the routes needed for managing clients.
     *
     * @return void
     */
    public function forClients()
    {
        $this->router->group(['middleware' => ['auth']], function () {
            $this->router->get('/clients', $this->prefix('ClientController@forUser'));
            $this->router->post('/clients', $this->prefix('ClientController@store'));
            $this->router->put('/clients/{clientId}', $this->prefix('ClientController@update'));
            $this->router->delete('/clients/{clientId}', $this->prefix('ClientController@destroy'));
        });
    }

    /**
     * Register the routes needed for managing personal access tokens.
     *
     * @return void
     */
    public function forPersonalAccessTokens()
    {
        $this->router->group(['middleware' => ['auth']], function () {
            $this->router->get('/scopes', $this->prefix('ScopeController@all'));
            $this->router->get('/personal-access-tokens', $this->prefix('PersonalAccessTokenController@forUser'));
            $this->router->post('/personal-access-tokens', $this->prefix('PersonalAccessTokenController@store'));
            $this->router->delete('/personal-access-tokens/{tokenId}', $this->prefix('PersonalAccessTokenController@destroy'));
        });
    }
}