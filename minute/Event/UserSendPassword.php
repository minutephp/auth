<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 9/4/2016
 * Time: 6:30 AM
 */
namespace Minute\Event {

    class UserSendPassword extends UserEvent {
        const USER_SEND_PASSWORD = "user.send.password";
        /**
         * @var bool
         */
        private $handled = false;

        /**
         * @return boolean
         */
        public function isHandled(): bool {
            return $this->handled;
        }

        /**
         * @param boolean $handled
         *
         * @return UserSendPassword
         */
        public function setHandled(bool $handled): UserSendPassword {
            $this->handled = $handled;

            return $this;
        }
    }
}