<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/6/2016
 * Time: 6:03 PM
 */
namespace Minute\Auth {

    use App\Model\User;
    use Illuminate\Database\QueryException;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserSignupEvent;
    use Minute\Log\LoggerEx;
    use Minute\Model\ModelAutoFill;
    use Minute\Routing\Router;
    use Minute\Tracker\Tracker;

    class CreateNewUser {
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var ModelAutoFill
         */
        private $modelAutoFill;
        /**
         * @var LoggerEx
         */
        private $logger;

        /**
         * LoginHandler constructor.
         *
         * @param Dispatcher $dispatcher
         * @param ModelAutoFill $modelAutoFill
         * @param LoggerEx $logger
         */
        public function __construct(Dispatcher $dispatcher, ModelAutoFill $modelAutoFill, LoggerEx $logger) {
            $this->dispatcher    = $dispatcher;
            $this->modelAutoFill = $modelAutoFill;
            $this->logger        = $logger;
        }

        public function signup(UserSignupEvent $event) {
            $signup = [];
            $fields = ['ident', 'email', 'contact_email', 'password', 'first_name', 'last_name', 'photo_url', 'tz_offset', 'ip_addr', 'http_referrer', 'http_campaign', 'verified'];

            $default = function ($field) use ($event) {
                if (($field == 'photo_url') && ($email = $event->email)) {
                    $gravatar = sprintf("http://www.gravatar.com/avatar/%s?d=404", md5(strtolower($email)));

                    if ($headers = get_headers($gravatar, 1)) {
                        if (strpos($headers[0], '200')) {
                            return $gravatar;
                        }
                    }
                } elseif ($field == 'contact_email') {
                    return $event->email ?? null;
                } elseif ($field == 'password') {
                    return bin2hex(openssl_random_pseudo_bytes(4));
                } elseif ($field == 'http_referrer') {
                    $value = $_COOKIE[Tracker::HTTP_REFERRER_COOKIE] ?? '/';

                    return $value !== '/' ? $value : null;
                } elseif ($field == 'http_campaign') {
                    return $_COOKIE[Tracker::HTTP_CAMPAIGN_COOKIE] ?? null;
                } elseif ($field == 'tz_offset') {
                    return $_COOKIE['tz_offset'] ?? 240;
                } elseif ($field == 'verified') {
                    return 'false';
                }

                return null;
            };

            foreach ($fields as $field) {
                $signup[$field] = $event->$field ?? $default($field);

                if ($field == 'password') {
                    $signup[$field] = password_hash($signup[$field], PASSWORD_DEFAULT);
                }
            }

            if (filter_var($signup['email'] ?? null, FILTER_VALIDATE_EMAIL) || !empty($signup['ident'])) {
                try {
                    User::unguard();

                    $user = new User($signup);
                    $this->modelAutoFill->fillMissing($user);

                    if ($user->save()) {
                        $event->setUser($user);

                        $signupEvent = (new UserSignupEvent($signup))->setUser($user);

                        try {
                            $this->dispatcher->fire(UserSignupEvent::USER_SIGNUP_COMPLETE, $signupEvent);
                        } catch (\Throwable $e) {
                            $this->logger->warn("Plugin error during signup: " . $e->getMessage());
                        }
                    }
                } catch (QueryException $e) {
                    $event->setError("EMAIL_IN_USE");
                } catch (\Exception $e) {
                    $event->setError($e->getMessage());
                }
            } else {
                $event->setError('INVALID_DATA');
            }

            if (!$event->getUser()) { //for logging
                $this->dispatcher->fire(UserSignupEvent::USER_SIGNUP_FAIL, $event);
            }
        }
    }
}