<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 11/5/2016
 * Time: 11:04 AM
 */
namespace Minute\Todo {

    use Illuminate\Support\Facades\Auth;
    use Minute\Config\Config;
    use Minute\Event\ImportEvent;
    use Minute\Provider\AuthProviders;

    class AuthTodo {
        /**
         * @var TodoMaker
         */
        private $todoMaker;
        /**
         * @var Config
         */
        private $config;

        /**
         * MailerTodo constructor.
         *
         * @param TodoMaker $todoMaker - This class is only called by TodoEvent (so we assume TodoMaker is be available)
         * @param Config $config
         */
        public function __construct(TodoMaker $todoMaker, Config $config) {
            $this->todoMaker = $todoMaker;
            $this->config    = $config;
        }

        public function getTodoList(ImportEvent $event) {
            $logins    = ['Twitter', 'Google', 'Facebook'];
            $providers = $this->config->get(AuthProviders::AUTH_PROVIDER_KEY . '/providers');

            foreach ($logins as $login) {
                $enabled = false;

                foreach ($providers as $provider) {
                    if ($provider['name'] === $login) {
                        $enabled = $provider['enabled'] == 'true';
                        break;
                    }
                }

                $todos[] = ['name' => "Enable $login login provider", 'status' => $enabled ? 'complete' : 'incomplete', 'link' => '/admin/logins'];

                if ($enabled) {
                    $todos[] = $this->todoMaker->createManualItem("check-$login-login", "Check $login login", "Check $login login app is working properly", '/login');
                }
            }

            $todos[] = $this->todoMaker->createManualItem("check-forgot-password-email", "Check forgot password email", 'Check email is being delivered and working properly', '/forgot-password');

            $event->addContent(['Authentication' => $todos ?? []]);
        }
    }
}