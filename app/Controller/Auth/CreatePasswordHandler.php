<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:34 PM
 */
namespace App\Controller\Auth {

    use App\Model\User;
    use Minute\Error\UserLoginError;
    use Minute\Error\UserUpdateDataError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserLoginEvent;
    use Minute\Event\UserUpdateDataEvent;
    use Minute\Session\Session;

    class CreatePasswordHandler {
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
            if (!empty($_params['password'])) {
                if ($user = User::find($this->session->getLoggedInUserId())) {
                    $event = new UserUpdateDataEvent($user, ['password' => $_params['password']]);
                    $this->dispatcher->fire(UserUpdateDataEvent::USER_UPDATE_DATA, $event);

                    if ($event->isHandled()) {
                        return json_encode((['update' => 'PASSWORD_RESET']));
                    } else {
                        throw new UserUpdateDataError($event->getError() ?: 'UNKNOWN_ERROR');
                    }
                } else {
                    throw new UserUpdateDataError('UNKNOWN_USER');
                }
            } else {
                throw new UserUpdateDataError('INVALID_DATA');
            }
        }
    }
}