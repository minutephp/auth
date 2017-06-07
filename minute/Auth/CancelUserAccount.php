<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 6/8/2017
 * Time: 2:27 AM
 */

namespace Minute\Auth {

    use Carbon\Carbon;
    use Minute\Event\UserAccountCancelEvent;
    use Minute\Session\Session;

    class CancelUserAccount {
        /**
         * @var Session
         */
        private $session;

        /**
         * CancelUserAccount constructor.
         *
         * @param Session $session
         */
        public function __construct(Session $session) {
            $this->session = $session;
        }

        public function cancel(UserAccountCancelEvent $event) {
            if ($user = $event->getUser()) {
                $user->deleted_at = Carbon::now();
                $user->deleted    = 'true';
                $user->verified   = 'false';
                $user->password   = password_hash(sha1(rand()), PASSWORD_DEFAULT);
                $user->email      = 'deleted-' . $user->email;

                if ($user->save()) {
                    $this->session->destroySession();
                    $event->setHandled(true);
                }
            }
        }
    }
}