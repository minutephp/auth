<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/24/2016
 * Time: 1:11 PM
 */
namespace Minute\Event {

    class UserLogoutEvent extends UserEventHandler {
        const USER_LOGOUT_SUCCESS = "user.logout.success";
    }
}