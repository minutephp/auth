<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 5:57 PM
 */
namespace Minute\Event {

    use HumanNameParser\Parser;
    use Minute\Utils\Sniffer;

    class UserSignupEvent extends UserEventHandler {
        const USER_SIGNUP_BEGIN    = "user.signup.begin";
        const USER_SIGNUP_COMPLETE = "user.signup.complete";
        const USER_SIGNUP_FAIL     = "user.signup.fail";

        /**
         * @var
         */
        private $signupData;

        /**
         * UserSignupEvent constructor.
         *
         * @param array $signupData
         */
        public function __construct(array $signupData) {
            parent::__construct();

            $this->signupData = $signupData;
        }

        /**
         * @return mixed
         */
        public function getSignupData() {
            if (empty($this->signupData['ip_addr'])) {
                $this->signupData['ip_addr'] = (new Sniffer())->getUserIP();
            }

            if (empty($this->signupData['tz_offset'])) {
                $this->signupData['tz_offset'] = 0;
            }

            if (empty($this->signupData['full_name'])) {
                $this->signupData['full_name'] = @trim(sprintf('%s %s', $this->signupData['first_name'], $this->signupData['last_name'])) ?: 'Member';
            }

            if (empty($this->signupData['first_name']) && !empty($this->signupData['full_name'])) {
                $nameParser = new Parser(['mandatory_last_name' => false]);

                if ($name = $nameParser->parse($this->signupData['full_name'])) {
                    $this->signupData['first_name'] = $name->getFirstName();
                    $this->signupData['last_name']  = $name->getLastName();
                }
            }

            return $this->signupData;
        }

        /**
         * @param mixed $signupData
         *
         * @return UserSignupEvent
         */
        public function setSignupData($signupData) {
            $this->signupData = $signupData;

            return $this;
        }

        public function __get($name) {
            $signupData = $this->getSignupData();

            return $signupData[$name] ?? null;
        }
    }
}