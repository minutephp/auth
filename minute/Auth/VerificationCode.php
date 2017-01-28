<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 1/5/2017
 * Time: 2:47 PM
 */
namespace Minute\Auth {

    use Minute\Crypto\Blowfish;

    class VerificationCode {
        /**
         * @var Blowfish
         */
        private $blowfish;

        /**
         * VerificationCode constructor.
         *
         * @param Blowfish $blowfish
         */
        public function __construct(Blowfish $blowfish) {
            $this->blowfish = $blowfish;
        }

        public function getVerificationCode(int $user_id) {
            return $this->blowfish->encrypt($user_id);
        }
    }
}