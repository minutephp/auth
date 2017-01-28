<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:57 PM
 */
namespace Minute\Event {

    class UserLoginEvent extends UserEventHandler {
        const USER_LOGIN_AUTHENTICATE = "user.login.authenticate";
        const USER_LOGIN_SUCCESS      = "user.login.success";
        const USER_LOGIN_FAIL         = "user.login.fail";
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
         * @return UserLoginEvent
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