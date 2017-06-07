<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:57 PM
 */

namespace Minute\Event {

    use App\Model\User;

    class UserAccountCancelEvent extends UserEventHandler {
        const USER_CANCEL_ACCOUNT = "user.cancel.account";

        public function __construct(User $user) {
            parent::__construct();

            $this->setUser($user);
        }
    }
}