<?php
require 'vendor/autoload.php';
include_once('server/database.php');
$guid = \Fpay\Xid\Generator::create();
$usersStore = new SleekDB\Store(Database::users, Database::dir);
if(!$usersStore->findOneBy(['username', '=', 'twosix'])) {
    $user = [
        "username" => 'twosix',
        "email" => 'twopsix@duck.com',
        "password" => '$2y$10$6f8eEwTLVPm7jm1qOcnpW.XV498fw3Ul1qpicmko0a7iR01QQtimi',
        "xid_id" => $guid->encode(),
        "pastes" => array(),
        "role" => 'owner'
    ];
    $usersStore->insert($user);
}
include 'server/routes/index.php';