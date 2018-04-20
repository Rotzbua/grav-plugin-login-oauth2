<?php
namespace Grav\Plugin\Login\OAuth2\Providers;

use League\OAuth2\Client\Provider\Instagram;

class InstagramProvider extends BaseProvider
{
    protected $name = 'Instagram';

    /** @var Instagram */
    protected $provider;

    public function __construct(array $options)
    {
        $options += [
            'clientId'      => $this->config->get('plugins.login-oauth2.providers.instagram.client_id'),
            'clientSecret'  => $this->config->get('plugins.login-oauth2.providers.instagram.client_secret'),
            'redirectUri'   => $this->config->get('plugins.login-oauth2.callback_uri'),
            'host'          => $this->config->get('plugins.login-oauth2.providers.instagram.options.host')
        ];

        parent::__construct($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('plugins.login-oauth2.providers.instagram.options.scope');

        return $this->provider->getAuthorizationUrl($options);
    }
}