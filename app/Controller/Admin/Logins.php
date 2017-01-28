<?php
/**
 * Created by: MinutePHP framework
 */
namespace App\Controller\Admin {

    use Minute\Routing\RouteEx;
    use Minute\View\Helper;
    use Minute\View\View;

    class Logins {

        public function index (RouteEx $_route) {
            return (new View())->with(new Helper('NgSort'));
        }
	}
}