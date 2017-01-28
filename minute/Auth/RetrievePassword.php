<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/4/2016
 * Time: 6:27 AM
 */
namespace Minute\Auth {

    use App\Model\User;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserForgotPasswordEvent;
    use Minute\Event\UserSendPassword;

    class RetrievePassword {
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * RetrievePassword constructor.
         *
         * @param Dispatcher $dispatcher
         */
        public function __construct(Dispatcher $dispatcher) {
            $this->dispatcher = $dispatcher;
        }

        public function retrieve(UserForgotPasswordEvent $event) {
            if ($email = $event->email) {      //make sure the user isn't already authenticated!
                if ($user = User::where('email', '=', $email)->first()) {
                    $sendEvent = new UserSendPassword($user->user_id);
                    $this->dispatcher->fire(UserSendPassword::USER_SEND_PASSWORD, $sendEvent);
                    $event->setHandled($sendEvent->isHandled());
                } else {
                    $event->setError('EMAIL_INVALID');
                }
            } else {
                $event->setError('INVALID_INPUT');
            }
        }
    }
}