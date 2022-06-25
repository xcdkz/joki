<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$pastePublicPost = function (Request $req, Response $res) use ($hcaptcha) {
    $pastes = new Store(Database::pastes, Database::dir);
    $params = json_decode($req->getBody());
    if(trim($params->title) === '' || trim($params->content) === '') {
        return $res -> withStatus(406);
    }
    if(!$hcaptcha->verify($params->h_captcha_response)) {
        return $res -> withStatus(401);
    } else {
        $guid = \Fpay\Xid\Generator::create();
        $user = '';
        $usersStore = new Store(Database::users, Database::dir);
        if($params->token) {
            $id = decode_token($params->token)['id'];
            $user = $usersStore->findOneBy(['xid_id', '=', $id]);
            if(!isset($user)) {
                $user = ['username' => 'Anonymous', '_id' => 0];
            }
        } else {
            $user = ['username' => 'Anonymous', '_id' => 0];
        }
        $paste = [
            "title" => $params->title,
            "content" => $params->content,
            "date" => date('Y-m-d H:i:s'),
            "xid_id" => $guid->encode(),
            "visibility" => $params->visibility,
            "owners" => array($user['_id']),
            "creator" => $user['_id'],
            "creator_username" => $user['username']
        ];
        $results = $pastes->insert($paste);
        if($user['_id'] !== 0) {
            $user['pastes'][] = $results['_id'];
            $usersStore->updateById($user['_id'], ['pastes' => $user['pastes']]);
        }
        return $res
            ->withHeader('Location', '/paste/' . $results['xid_id'])
            ->withStatus(302);
    }
};

$pasteGetWithIdPage = function (Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/paste/paste.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};

$pasteGetWithId = function (Request $req, Response $res, $args) {
    $pasteStore = new Store(Database::pastes, Database::dir);
    $content = $pasteStore -> findOneBy([['xid_id', '=', $args['id']], [['visibility', '=', 'pub'], 'OR', ['visibility', '=', 'unl']]]);
    if(!isset($content)) {
        $params = json_decode($req->getBody());
        if($params->token === null) {
            $res -> getBody() -> write($params);
            return $res -> withStatus(403);
        }
        $tokArray = decode_token($params->token);
        $usersStore = new Store(Database::users, Database::dir);
        $userInStore = $usersStore -> findOneBy(['xid_id', '=', $tokArray['id']]);
        if(!isset($userInStore)) {
            return $res -> withStatus(401);
        }
        $content = $pasteStore -> findOneBy([['owners', 'CONTAINS', $userInStore['_id']], ['xid_id', '=', $args['id']]]);
        if(!isset($content)) {
            return $res -> withStatus(404);
        }
        $res -> getBody() -> write(json_encode($content));
        return $res -> withStatus(200);
    }
    $res -> getBody() -> write(json_encode($content));
    return $res -> withStatus(200);
};

$pastePublicGet = function (Request $req, Response $res) {
    $pasteStore = new Store(Database::pastes, Database::dir);
    if(!isset($_GET['number'])) {
        return $res -> withStatus(404);
    }
    $content = json_encode($pasteStore->findBy(['visibility', '=', 'pub'], ['_id' => 'desc'], $_GET['number']));
    if(!$content) {
        return $res -> withStatus(404);
    }
    $res -> getBody() -> write($content);
    return $res -> withStatus(200);
};
