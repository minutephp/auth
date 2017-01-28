<?php

/** @var Binding $binding */
use Minute\Auth\CheckUserLogin;
use Minute\Auth\RetrievePassword;
use Minute\Auth\UpdateUserData;
use Minute\Event\AdminEvent;
use Minute\Event\Binding;
use Minute\Event\TodoEvent;
use Minute\Event\UserForgotPasswordEvent;
use Minute\Event\UserLoginEvent;
use Minute\Event\UserUpdateDataEvent;
use Minute\Menu\AuthMenu;
use Minute\Todo\AuthTodo;

$binding->addMultiple([
    //auth
    ['event' => UserLoginEvent::USER_LOGIN_AUTHENTICATE, 'handler' => [CheckUserLogin::class, 'authenticate']],
    ['event' => UserForgotPasswordEvent::USER_FORGOT_PASSWORD, 'handler' => [RetrievePassword::class, 'retrieve']],
    ['event' => UserUpdateDataEvent::USER_UPDATE_DATA, 'handler' => [UpdateUserData::class, 'update']],

    ['event' => "import.admin.menu.links", 'handler' => [AuthMenu::class, 'adminLinks']],

    //tasks
    ['event' => TodoEvent::IMPORT_TODO_ADMIN, 'handler' => [AuthTodo::class, 'getTodoList']],
]);