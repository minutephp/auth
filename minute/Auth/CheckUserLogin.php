<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 6:03 PM
 */
namespace Minute\Auth {

    use App\Model\User;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserLoginEvent;

    class CheckUserLogin {
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * LoginHandler constructor.
         *
         * @param Dispatcher $dispatcher
         */
        public function __construct(Dispatcher $dispatcher) {
            $this->dispatcher = $dispatcher;
        }

        public function authenticate(UserLoginEvent $event) {
            if (empty($event->getUser()) && ($email = $event->email) && ($password = $event->password)) {      //make sure the user isn't already authenticated!
                if ($user = User::where('email', '=', $email)->first()) {
                    if (password_verify($password, $user->password)) {
                        $event->setUser($user);
                        $this->dispatcher->fire(UserLoginEvent::USER_LOGIN_SUCCESS, $event);
                    } else {
                        $event->setError('PASSWORD_INVALID');
                    }
                } else {
                    $event->setError('EMAIL_INVALID');
                }
            } else {
                $event->setError('INVALID_INPUT');
            }

            if (!$event->getUser()) { //for logging
                $this->dispatcher->fire(UserLoginEvent::USER_LOGIN_FAIL, $event);
            }
        }
    }
}