<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:34 PM
 */
namespace App\Controller\Auth {

    use Minute\Error\UserLoginError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserLoginEvent;
    use Minute\Session\Session;

    class LoginHandler {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Session
         */
        private $session;

        /**
         * LoginPopup constructor.
         *
         * @param Dispatcher $dispatcher
         * @param Session $session
         */
        public function __construct(Dispatcher $dispatcher, Session $session) {
            $this->dispatcher = $dispatcher;
            $this->session    = $session;
        }

        public function index($_params) {
            $event = new UserLoginEvent($_params);
            $this->dispatcher->fire(UserLoginEvent::USER_LOGIN_AUTHENTICATE, $event);

            if ($user = $event->getUser()) {
                $this->session->startSession($user->user_id);

                return json_encode((['update' => ['user' => $user], 'event' => 'session_user_login']));
            } else {
                throw new UserLoginError($event->getError() ?: 'UNKNOWN_ERROR');
            }
        }
    }
}