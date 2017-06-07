<?php
/**
 * Created by: MinutePHP framework
 */

namespace App\Controller\Auth {

    use App\Model\User;
    use Illuminate\Database\QueryException;
    use Minute\Error\UserUpdateDataError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserSignupEvent;
    use Minute\Event\UserUpdateDataEvent;
    use Minute\Session\Session;

    class CompleteSignupHandler {
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
            if (!empty($_params['email'])) {
                /** @var User $user */
                if ($user = User::find($this->session->getLoggedInUserId())) {
                    try {
                        $event = new UserUpdateDataEvent($user, ['email' => $_params['email']]);
                        $this->dispatcher->fire(UserUpdateDataEvent::USER_UPDATE_DATA, $event);

                        if ($event->isHandled()) {
                            /** @var User $newUser */
                            $newUser     = User::find($this->session->getLoggedInUserId()); //get updated data
                            $signupEvent = (new UserSignupEvent($newUser->toArray()))->setUser($user);

                            $this->dispatcher->fire(UserSignupEvent::USER_SIGNUP_COMPLETE, $signupEvent);

                            return json_encode(['update' => ['user' => $user], 'event' => 'session_user_update']);
                        } else {
                            throw new UserUpdateDataError('UNKNOWN_ERROR');
                        }
                    } catch (QueryException $e) {
                        throw new UserUpdateDataError('EMAIL_IN_USE');
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