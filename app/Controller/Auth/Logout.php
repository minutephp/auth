<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Auth {

    use Minute\Event\Dispatcher;
    use Minute\Event\UserEvent;
    use Minute\Event\UserLogoutEvent;
    use Minute\Routing\RouteEx;
    use Minute\Session\Session;
    use Minute\View\Helper;
    use Minute\View\Redirection;
    use Minute\View\View;

    class Logout {
        /**
         * @var Session
         */
        private $session;
        /**
         * @var Dispatcher
         */
        private $dispatcher;

        /**
         * Logout constructor.
         *
         * @param Session $session
         * @param Dispatcher $dispatcher
         */
        public function __construct(Session $session, Dispatcher $dispatcher) {
            $this->session    = $session;
            $this->dispatcher = $dispatcher;
        }

        public function index() {
            $this->dispatcher->fire(UserLogoutEvent::USER_LOGOUT_SUCCESS, new UserLogoutEvent($this->session->getLoggedInUserId()));
            $this->session->destroySession();

            return new Redirection('/');
        }
    }
}