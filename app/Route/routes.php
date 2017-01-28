<?php

/** @var Router $router */
use Minute\Routing\Router;

$router->get('/login', 'Auth/Login', false);
$router->get('/signup', 'Auth/Signup', false);
$router->get('/forgot-password', 'Auth/ForgotPassword', false);
$router->get('/create-password', 'Auth/CreatePassword', true);
$router->get('/logout', 'Auth/Logout', true)->setDefault('_noView', true);

$router->get('/auth/login-popup', 'Generic/Popup', false);
$router->post('/auth/login-popup', 'Auth/LoginHandler', false);

$router->get('/auth/signup-popup', 'Generic/Popup', false);
$router->post('/auth/signup-popup', 'Auth/SignupHandler', false);

$router->get('/auth/forgot-password-popup', 'Generic/Popup', false);
$router->post('/auth/forgot-password-popup', 'Auth/ForgotPasswordHandler', false);

$router->get('/auth/create-password-popup', 'Generic/Popup', true);
$router->post('/auth/create-password-popup', 'Auth/CreatePasswordHandler', true);

$router->get('/auth/complete-signup-popup', 'Generic/Popup', false);
$router->post('/auth/complete-signup-popup', 'Auth/CompleteSignupHandler', false);

$router->get('/auth/verify-account', 'Auth/VerifyAccount', true);
$router->get('/auth/welcome', 'Auth/Welcome', true);


$router->get('/auth/fwd', 'Auth/Fwd', false)
       ->setDefault('_noView', true);
$router->get('/_auth/reload', 'Auth/Reload', true)
       ->setDefault('_noView', true);

$router->get('/admin/logins', 'Admin/Logins', 'admin', 'm_configs[type] as configs')
       ->setReadPermission('configs', 'admin')->setDefault('type', 'auth');
$router->post('/admin/logins', null, 'admin', 'm_configs as configs')
       ->setAllPermissions('configs', 'admin');

$router->get('/auth/hauth/{provider}', 'Auth/HAuth', false)
       ->setDefault('_noView', true);

