<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Auth {

    use Minute\Routing\RouteEx;
    use Minute\Session\Session;
    use Minute\View\Helper;
    use Minute\View\Redirection;
    use Minute\View\View;

    class Reload {
        /**
         * @var Session
         */
        private $session;

        /**
         * Reload constructor.
         *
         * @param Session $session
         */
        public function __construct(Session $session) {
            $this->session = $session;
        }

        public function index($redir = '') {
            $userId = $this->session->getLoggedInUserId();
            $this->session->destroySession();
            $this->session->startSession($userId);

            return new Redirection($redir ?: '/members');
        }
    }
}