<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Auth {

    use App\Model\User;
    use Minute\Auth\VerificationCode;
    use Minute\Config\Config;
    use Minute\Session\Session;
    use Minute\View\Redirection;
    use Minute\View\View;

    class VerifyAccount {
        /**
         * @var VerificationCode
         */
        private $verifier;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Config
         */
        private $config;

        /**
         * VerifyAccount constructor.
         *
         * @param Config $config
         * @param Session $session
         * @param VerificationCode $verifier
         */
        public function __construct(Config $config, Session $session, VerificationCode $verifier) {
            $this->config   = $config;
            $this->session  = $session;
            $this->verifier = $verifier;
        }

        public function index(string $code = '') {
            $user_id = $this->session->getLoggedInUserId();
            /** @var User $user */
            $user  = User::find($user_id);
            $redir = $this->config->get('private/urls/members', '/members');

            if ($user->verified == 'false') {
                $verify = $this->verifier->getVerificationCode($user_id);

                if ($code == $verify) {
                    $user->verified = 'true';
                    $user->save();

                    $message   = 'Thanks for verifying your account!';
                    $providers = $this->config->get('auth/providers');

                    if (is_array($providers)) {
                        foreach ($providers as $provider) {
                            if ($provider['name'] === 'Email') {
                                $hasPassword = !empty($provider['fields']['password']);
                                break;
                            }
                        }
                    }

                    if (empty($hasPassword)) {
                        return new Redirection(sprintf('/create-password?%s', http_build_query(['msg' => $message])));
                    }
                } else {
                    $error = 'Verification code is not valid';
                }
            } else {
                $error = 'Account is already verified';
            }

            return (new View('', ['error' => $error ?? '', 'message' => $message ?? '', 'redirect' => $redir]));
        }
    }
}