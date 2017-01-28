<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:34 PM
 */
namespace App\Controller\Auth {

    use Minute\Error\UserSignupError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserSignupEvent;
    use Minute\Session\Session;

    class SignupHandler {
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
            $user = $this->registerUser($_params);

            return json_encode(['update' => ['user' => $user], 'event' => 'session_user_signup']);
        }

        public function registerUser($_params) {
            $event = new UserSignupEvent($_params);
            $this->dispatcher->fire(UserSignupEvent::USER_SIGNUP_BEGIN, $event);

            if ($user = $event->getUser()) {
                $this->session->startSession($user->user_id);

                return $user;
            } else {
                throw new UserSignupError($event->getError() ?: 'UNKNOWN_ERROR');
            }
        }
    }
}