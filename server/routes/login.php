<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$loginGet = function (Request $req, Response $res) {
    include ('client/html/navbar.php');
    include ('client/html/login/login.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};

$loginPost = function (Request $req, Response $res) {
    $usersStore = new Store(Database::users, Database::dir);
    $params = json_decode($req->getBody());
    if(preg_match("/(@\S*\.\S*)$/", $params->user_mail)) {
        $userInStore = $usersStore -> findOneBy(['email', '=', $params->user_mail]);
    } else {
        $userInStore = $usersStore -> findOneBy(['username', '=', $params->user_mail]);
    }
    if($userInStore === null) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/login?userNotFound=true';
        $res -> getBody() -> write(json_encode(array('url' => $url)));
        return $res -> withStatus(401);
    } else if (!password_verify($params->password, $userInStore['password'])) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/login?incorrectPassword=true';
        $res -> getBody() -> write(json_encode(array('url' => $url)));
        return $res -> withStatus(401);
    } else {
        $url = 'http://' . $_SERVER['SERVER_NAME'];
        $token = generate_token(id: $userInStore['xid_id']);
        $res -> getBody() -> write(json_encode(array('url' => $url, 'token' => $token)));
        return $res -> withStatus(302);
    }
};
