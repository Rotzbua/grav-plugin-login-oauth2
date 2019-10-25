<?php
/* WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING WARNING
 * oauth2 token gives FULL access to nextcloud account.
 * If somebody steals the token from your Grav installation, they have full access to all your data!!
 */
namespace Grav\Plugin\Login\OAuth2\Providers;

class NextcloudProvider extends BaseProvider
{
    protected $name = 'Nextcloud';
    protected $classname = 'League\\OAuth2\\Client\\Provider\\GenericProvider';

    public function initProvider(array $options)
    {
        $url = $this->config->get('providers.nextcloud.url');

        $options += [
            'clientId'                => $this->config->get('providers.nextcloud.client_id'),
            'clientSecret'            => $this->config->get('providers.nextcloud.client_secret'),
            'urlAuthorize'            => $url.'/apps/oauth2/authorize',
            'urlAccessToken'          => $url.'/apps/oauth2/api/v1/token',
            'urlResourceOwnerDetails' => $url.'/ocs/v2.php/cloud/user?format=json'
        ];

        parent::initProvider($options);
    }

    public function getAuthorizationUrl()
    {
        $options = ['state' => $this->state];
        $options['scope'] = $this->config->get('providers.nextcloud.options.scope'); // currently (nextcloud 16) not supported but maybe in next versions

        return $this->provider->getAuthorizationUrl($options);
    }

    public function getUserData($user)
    {
        $data_user = [
            'id'       => $user->toArray()['ocs']['data']['id'], // id is currently not unique (nextcloud 16)
            'fullname' => $user->toArray()['ocs']['data']['display-name'],
            'email'    => $user->toArray()['ocs']['data']['email'],
        ];

        return $data_user;
    }
}
