<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$adminPanelPage = function(Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/admin/panel.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};

$adminGetUsers = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        if($user['role'] !== 'administrator' && $user['role'] !== 'owner') {
            return $res -> withStatus(401);
        }
        $res -> getBody() -> write(json_encode($usersStore->findAll()));
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};

$adminMakeAdmin = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token && $params->xid_id) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        if(!$user || $user['role'] !== 'owner') {
            return $res -> withStatus(401);
        }
        $new_admin = $usersStore -> findOneBy(['xid_id', '=', $params->xid_id]);
        if(!$new_admin) {
            return $res -> withStatus(404);
        }
        if($new_admin['role'] === 'owner') {
            return $res -> withStatus(401);
        }
        $usersStore -> updateById($new_admin['_id'], [
            'role' => 'administrator'
        ]);
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};

$adminRemoveUser = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token && $params->xid_id) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        if(!$user || !($user['role'] === 'owner' || $user['role'] === 'administrator')) {
            return $res -> withStatus(401);
        }
        $remove_user = $usersStore -> findOneBy(['xid_id', '=', $params->xid_id]);
        if(!$remove_user) {
            return $res -> withStatus(404);
        }
        if($remove_user['role'] === 'owner' || ($remove_user['role'] === 'administrator' && $user['role'] !== 'owner')) {
            return $res -> withStatus(401);
        }
        $usersStore -> deleteById($remove_user['_id']);
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};

$adminDegradeUser = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token && $params->xid_id) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        if(!$user || $user['role'] !== 'owner') {
            return $res -> withStatus(401);
        }
        $degrade_user = $usersStore -> findOneBy(['xid_id', '=', $params->xid_id]);
        if(!$degrade_user) {
            return $res -> withStatus(404);
        }
        if($degrade_user['role'] === 'owner') {
            return $res -> withStatus(401);
        }
        $usersStore -> updateById($degrade_user['_id'], [
            'role' => 'user'
        ]);
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};