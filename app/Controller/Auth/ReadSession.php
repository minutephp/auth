<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Auth {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class ReadSession {

        public function index (RouteEx $_route) {
            return (new View());
        }
	}
}