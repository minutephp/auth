<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:57 PM
 */
namespace Minute\Event {

    class UserForgotPasswordEvent extends UserEventHandler {
        const USER_FORGOT_PASSWORD = "user.forgot.password";
        /**
         * @var
         */
        private $loginData;

        /**
         * UserLoginEvent constructor.
         *
         * @param $loginData
         */
        public function __construct(array $loginData) {
            parent::__construct();
            $this->loginData = $loginData;
        }

        /**
         * @return mixed
         */
        public function getLoginData() {
            return $this->loginData;
        }

        /**
         * @param mixed $loginData
         *
         * @return UserForgotPasswordEvent
         */
        public function setLoginData($loginData) {
            $this->loginData = $loginData;

            return $this;
        }

        public function __get($name) {
            return $this->loginData[$name] ?? null;
        }
    }
}