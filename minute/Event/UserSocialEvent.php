<?php
/**
 * User: Sanchit <dev@minutephp.com>
 * Date: 10/19/2016
 * Time: 12:14 PM
 */
namespace Minute\Event {

    class UserSocialEvent extends UserEvent {
        //login signup using social providers like Google, Facebook, etc
        const USER_SOCIAL_SIGNUP = "user.social.signup";
        const USER_SOCIAL_LOGIN  = "user.social.login";

    }
}