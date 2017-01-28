<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Auth {

    use App\Model\User;
    use Minute\Crypto\JwtEx;
    use Minute\Event\Dispatcher;
    use Minute\Event\UserEvent;
    use Minute\Session\Session;
    use Minute\Utils\Sniffer;
    use Minute\View\Redirection;

    class Fwd {
        /**
         * @var JwtEx
         */
        private $jwtEx;
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Dispatcher
         */
        private $dispatcher;
        /**
         * @var Sniffer
         */
        private $sniffer;

        /**
         * Fwd constructor.
         *
         * @param JwtEx $jwtEx
         * @param Session $session
         * @param Dispatcher $dispatcher
         * @param Sniffer $sniffer
         */
        public function __construct(JwtEx $jwtEx, Session $session, Dispatcher $dispatcher, Sniffer $sniffer) {
            $this->jwtEx      = $jwtEx;
            $this->session    = $session;
            $this->dispatcher = $dispatcher;
            $this->sniffer = $sniffer;
        }

        public function index(string $jwt, string $url = '') {
            if ($payload = $this->jwtEx->decode($jwt)) {
                if ($user_id = $payload->user_id ?? 0) {
                    if ($user = User::find($user_id)) {
                        if (!empty($payload->authorize)) {
                            /** @var User $user */
                            if ($user->verified == 'n') {
                                $user->ip_addr  = $this->sniffer->getUserIP();
                                $user->verified = 'y';
                                $user->save();
                            }

                            $this->session->startSession($user_id);
                        }

                        if (!empty($payload->eventName)) {
                            $event = new UserEvent($user_id, $user->toArray());
                            $event->setData($payload->eventData ?? '');
                            $this->dispatcher->fire($payload->eventName, $event);
                        }
                    }
                }
            } else {
                $params = ['msg' => 'Sorry this link has expired'];
            }

            return new Redirection($url ?: '/', $params ?? []);
        }
    }
}