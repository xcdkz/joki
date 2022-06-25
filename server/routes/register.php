<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$registerGet = function (Request $req, Response $res) {
    include ('client/html/navbar.php');
    if($_GET['email_exists']) {
        echo "Email already exists in the database";
    } elseif ($_GET['user_exists']) {
        echo "User already exists in the database";
    }
    include ('client/html/register/register.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};

$registerPost = function (Request $req, Response $res) {
    $usersStore = new Store(Database::users, Database::dir);
    $params = json_decode($req->getBody());
    if($params -> password !== $params -> password2) {
        return $res -> withStatus(406);
    }
    if(strlen($params->username) > 20 || strlen($params->email) > 20 || strlen($params->password) > 20) {
        return $res -> withStatus(406);
    }
    $userInStore = $usersStore -> findOneBy(['username', '=', $params -> username]) !== null;
    $mailInStore = $usersStore -> findOneBy(['email', '=', $params -> email]) !== null;
    if($userInStore || $mailInStore) {
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/register?' . match (true) {
                $userInStore && $mailInStore => 'user_exists=true&email_exists=true',
                $userInStore => 'user_exists=true',
                $mailInStore => 'email_exists=true'
            };
        $payload = json_encode(array('url' => $url));
        $res -> getBody() -> write($payload);
        return $res -> withStatus(401);
    }
    $guid = \Fpay\Xid\Generator::create();
    $user = [
        "username" => $params->username,
        "email" => $params->email,
        "password" => password_hash($params->password, PASSWORD_DEFAULT),
        "xid_id" => $guid->encode(),
        "pastes" => array(),
        "role" => 'user'
    ];
    $result = $usersStore -> insert($user);
    $token = generate_token(id: $result['xid_id']);
    $url = 'http://' . $_SERVER['SERVER_NAME'] . '/';
    $payload = json_encode(array('url' => $url, 'token' => $token));
    $res -> getBody() -> write($payload);
    return $res -> withStatus(302);
};
