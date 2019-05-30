<?php
require_once('Middleware.php');
require_once('ThrottlingMiddleware.php');
require_once('Server.php');
require_once('UserExistsMiddleware.php');
require_once('RoleCheckMiddleware.php');

$server = new Server();
$server->register('admin@example.com', 'admin_pass');
$server->register('user@plm.com', 'user_pass');

$throtMid = new ThrottlingMiddleware(2);
$throtMid
    ->linkWith(new UserExistsMiddleware($server))
    ->linkWith(new RoleCheckMiddleware());
$server->setMiddleware($throtMid);

// Facem un do while in care cer loginul
// pana avem o autentificare reusita

do{
    $success = false;
    echo "Please enter your email\n";
    $email = readline();
    echo "Enter your password";
    $password = readline();
    $success = $server->login($email, $password);
} while(!$success);


