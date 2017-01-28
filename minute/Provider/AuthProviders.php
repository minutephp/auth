<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/3/2016
 * Time: 5:54 AM
 */
namespace Minute\Provider {

    use Minute\Config\Config;
    use Minute\Event\AuthProviderEvent;

    class AuthProviders {
        const AUTH_PROVIDER_KEY = "auth";
        /**
         * @var Config
         */
        private $config;

        /**
         * AuthProviders constructor.
         *
         * @param Config $config
         */
        public function __construct(Config $config) {
            $this->config = $config;
        }

        public function getEnabled() {
            return array_filter($this->getProviders(), function ($p) { return @$p['enabled'] === true; });
        }

        public function getProviders() {
            return $this->config->get(self::AUTH_PROVIDER_KEY . '/providers', [['name' => 'Email', 'enabled' => true]]);
        }

        public function getProvider($provider) {
            return !empty($provider) ? array_values(array_filter($this->getProviders() ?? [], function ($p) use ($provider) { return strcasecmp($p['name'], $provider) == 0; }) ?: [])[0] : null;
        }
    }
}