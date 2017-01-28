<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Auth {

    use App\Model\User;
    use Exception;
    use Hybrid_Auth;
    use Hybrid_Endpoint;
    use Minute\Error\HybridAuthError;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserSignupEvent;
    use Minute\Event\UserSocialEvent;
    use Minute\Provider\AuthProviders;
    use Minute\Session\Session;

    class HAuth {
        /**
         * @var AuthProviders
         */
        private $providers;
        /**
         * @var SignupHandler
         */
        private $signupHandler;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * HAuth constructor.
         *
         * @param AuthProviders $providers
         * @param SignupHandler $signupHandler
         * @param Session $session
         * @param Dispatcher $dispatcher
         */
        public function __construct(AuthProviders $providers, SignupHandler $signupHandler, Session $session, Dispatcher $dispatcher) {
            $this->providers     = $providers;
            $this->signupHandler = $signupHandler;
            $this->session       = $session;
            $this->dispatcher    = $dispatcher;
        }

        /**
         * @param $provider
         *
         * @throws HybridAuthError
         */
        public function index($provider) {
            if (isset($_REQUEST['hauth_start']) || isset($_REQUEST['hauth_done'])) {
                Hybrid_Endpoint::process();
            } else {
                try {
                    $map      = ['Facebook' => 'id', 'Google' => 'id', 'GitHub' => 'id'];
                    $settings = ['Facebook' => ['scope' => 'email', 'display' => 'popup'], 'Google' => ['scope' => 'https://www.googleapis.com/auth/userinfo.email'],
                                 'Twitter' => ['includeEmail' => true]];
                    $config   = $this->providers->getProvider($provider);

                    if (!empty($config['key']) && !empty($config['secret'])) {
                        $pConfig = array_merge(['enabled' => true, "keys" => [$map[$provider] ?? 'key' => $config['key'], 'secret' => $config['secret']]], $settings[$provider] ?? []);
                        $config  = ["providers" => [$provider => $pConfig]];
                        $hauth   = new Hybrid_Auth($config);
                        $auth    = $hauth->authenticate($provider);

                        if ($profile = $auth->getUserProfile()) {
                            $event = 'session_user_login';
                            $data  = ['ident' => $profile->identifier, 'email' => $profile->email, 'first_name' => $profile->firstName, 'last_name' => $profile->lastName,
                                      'photo_url' => $profile->photoURL, 'verified' => 'true'];

                            /** @var User $user */
                            if ($user = User::where('ident', '=', $profile->identifier)->first()) {
                                if (empty($user->email) && !empty($profile->email)) {
                                    $user->email = $profile->email;
                                    $user->save();
                                }

                                if (!empty($profile->email)) {
                                    $user->contact_email = $profile->email;
                                    $user->save();
                                }
                            } elseif (!empty($profile->email) && ($user = User::where('email', '=', $profile->email)->first())) {
                                $user->ident = $profile->identifier;
                                $user->save();
                            } else {
                                $user  = $this->signupHandler->registerUser($data);
                                $event = 'session_user_signup';
                            }

                            if ($user_id = $user->user_id ?? null) {
                                $this->session->startSession($user_id);

                                $socialEvent = new UserSocialEvent($user->user_id, array_merge((array) $profile, ['provider' => $provider]));
                                $this->dispatcher->fire($event === 'session_user_signup' ? UserSocialEvent::USER_SOCIAL_SIGNUP : UserSocialEvent::USER_SOCIAL_LOGIN, $socialEvent);

                                $userData = json_encode(['user' => $user->toArray()]);
                                printf("<scrip" . "t>try { self.opener.Minute.setSessionData(%s, '%s'); } catch(err) { console.log(err); } finally { self.window.close(); }</script>", $userData, $event);
                            }
                        }
                    } else {
                        throw new Exception("Configuration for $provider is incomplete");
                    }
                } catch (\Throwable $e) {
                    Hybrid_Auth::logoutAllProviders();

                    throw new HybridAuthError($e->getMessage());
                }
            }
        }
    }
}