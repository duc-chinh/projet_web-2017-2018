<?php

$authTableData = [
    'table' => 'users',
    'idfield' => 'login',
    'cfield' => 'mdp',
    'uidfield' => 'uid',
    'rfield' => 'role',
];

$pathFor = [
    // === INCLUDES ===
    "favicon"   => "/projet_web 2017-2018/images/favicon.ico",
    "logo"      => "/projet_web 2017-2018/images/logo.png",
    "logo-menu" => "/projet_web 2017-2018/images/logo_menu.png",
    "bootstrap" => "/projet_web 2017-2018/styles/bootstrap-3.3.7/dist/css/bootstrap.min.css",
    "navbar"    => "/projet_web 2017-2018/styles/navbar-fixed-left.min.css",
    "style"     => "/projet_web 2017-2018/styles/style.css",
    "jquery"    => "/projet_web 2017-2018/styles/bootstrap-3.3.7/dist/js/jquery-3.2.1.js",
    "js"        => "/projet_web 2017-2018/styles/bootstrap-3.3.7/dist/js/bootstrap.min.js",
    // === END INCLUDES ===
    // === REDIRECT ===
    "root"              => "/projet_web 2017-2018/index.php",
    "login"             => "/projet_web 2017-2018/modules/login.php",
    "logout"            => "/projet_web 2017-2018/modules/logout.php",
    "adduser"           => "/projet_web 2017-2018/modules/signup.php",
    "events_list"       => "/projet_web 2017-2018/modules/events/events_list.php",
    "users_list"        => "/projet_web 2017-2018/modules/users/users_list.php",
    "participants_list" => "/projet_web 2017-2018/modules/participants/participants_list.php",
    "itypes_list"       => "/projet_web 2017-2018/modules/itypes/itypes_list.php",
    "dashboard"         => "/projet_web 2017-2018/modules/dashboard/dashboard.php",
    "badging__add"      => "/projet_web 2017-2018/modules/badging/badging__add.php",
    "search"            => "/projet_web 2017-2018/modules/search/search.php",
    // === END REDIRECT ===
];

const SKEY = '_Redirect';
