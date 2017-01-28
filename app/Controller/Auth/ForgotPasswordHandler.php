<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:34 PM
 */
namespace App\Controller\Auth {

    use Minute\Error\UserForgotPasswordError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserForgotPasswordEvent;
    use Minute\Session\Session;

    class ForgotPasswordHandler {
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
         */
        public function __construct(Dispatcher $dispatcher) {
            $this->dispatcher = $dispatcher;
        }

        public function index($_params) {
            $event = new UserForgotPasswordEvent($_params);
            $this->dispatcher->fire(UserForgotPasswordEvent::USER_FORGOT_PASSWORD, $event);

            if ($event->isHandled()) {
                return json_encode((['update' => 'PASSWORD_SENT']));
            } else {
                throw new UserForgotPasswordError($event->getError() ?: 'UNKNOWN_ERROR');
            }
        }
    }
}