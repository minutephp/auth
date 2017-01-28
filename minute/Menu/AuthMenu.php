<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 7/8/2016
 * Time: 7:57 PM
 */
namespace Minute\Menu {

    use Minute\Event\ImportEvent;

    class AuthMenu {
        public function adminLinks(ImportEvent $event) {
            $links = [
                'logins' => ['title' => 'Social logins', 'icon' => 'fa-sign-in', 'priority' => 1, 'parent' => 'expert', 'href' => '/admin/logins']
            ];

            $event->addContent($links);
        }
    }
}