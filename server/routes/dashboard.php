<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$dashboardGetPage = function(Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/dashboard/dashboard.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};

$dashboardGetPastes = function(Request $req, Response $res) {
     $params = json_decode($req->getBody());
     if($params->token) {
         $id = decode_token($params->token)['id'];
         $usersStore = new Store(Database::users, Database::dir);
         $user = $usersStore->findOneBy(['xid_id', '=', $id]);
         if(!isset($user)) {
             return $res -> withStatus(404);
         }
         $str = '[';
         $pastesStore = new Store(Database::pastes, Database::dir);
         foreach($user['pastes'] as $p) {
             $paste = $pastesStore -> findById($p);
             $fpaste = [
                 '_id' => $paste['_id'],
                 'url' => 'http://' . $_SERVER['SERVER_NAME'] . '/paste/' . $paste['xid_id'],
                 'title' => $paste['title'],
                 'creator' => $paste['creator_username'],
                 'owners' => $paste['owners'],
                 'date' => $paste['date'],
                 'visibility' => $paste['visibility']
             ];
             $str .= json_encode($fpaste) . ',';
         }
         $str = substr($str, 0, -1) . ']';
         $res -> getBody() -> write($str);
         return $res -> withStatus(200);
     }
     return $res -> withStatus(401);
};

$dashboardRemovePaste = function(Request $req, Response $res, $args) {
    $params = json_decode($req->getBody());
    if($params->token) {
        $usersStore = new Store(Database::users, Database::dir);
        $token = decode_token($params->token);
        $user = $usersStore->findOneBy(['xid_id', '=', $token['id']]);
        if(!$user) {
            return $res->withStatus(401);
        }
        $pasteStore = new Store(Database::pastes, Database::dir);
        $paste = $pasteStore->findById($args['id']);
        if(!$paste) {
            return $res->withStatus(404);
        }
        if(!in_array($user['_id'], $paste['owners'])) {
            return $res->withStatus(405);
        }
        if(!in_array($args['id'], $user['pastes'])) {
            return $res -> withStatus(406);
        }
        $pasteStore->deleteById($args['id']);
        $user['pastes'] = array_diff($user['pastes'], [$paste['_id']]);
        $usersStore->updateById($user['_id'], ['pastes' => $user['pastes']]);
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};

$dashboardEditPastePage = function(Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/dashboard/edit.php');
    include('client/html/footer.php');
    return $res->withStatus(200);
};

$dashboardEditGetPaste = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token && $params->paste_id) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        $pastesStore = new Store(Database::pastes, Database::dir);
        $paste = $pastesStore -> findById($params->paste_id);
        if(!$user || !$paste || !in_array($user['_id'], $paste['owners'])) {
            return $res -> withStatus(401);
        }
        $res -> getBody() -> write(json_encode(array(
            'title' => $paste['title'],
            'content' => $paste['content'],
            'visibility' => $paste['visibility']
        )));
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};

$dashboardEditSubmitPaste = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token
    && $params->title
    && $params->content
    && $params->paste_id) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        $pastesStore = new Store(Database::pastes, Database::dir);
        $paste = $pastesStore -> findById($params->paste_id);
        if(!$user || !$paste || !in_array($user['_id'], $paste['owners'])) {
            return $res -> withStatus(401);
        }
        $pastesStore -> updateById($paste['_id'], [
            'title' => $params->title,
            'content' => $params->content
        ]);
        $res -> getBody() -> write(json_encode(array(
            'url' => 'http://' . $_SERVER['SERVER_NAME'] . '/dashboard',
        )));
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};

$dashboardEditAddOwner = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token
    && $params->paste_id
    && $params->new_owner) {
        $token = decode_token($params->token);
        if(empty($token)) {
            return $res -> withStatus(401);
        }
        $usersStore = new Store(Database::users, Database::dir);
        $user = $usersStore -> findOneBy(['xid_id', '=', $token['id']]);
        $pastesStore = new Store(Database::pastes, Database::dir);
        $paste = $pastesStore -> findById($params->paste_id);
        if(!$user
        || !$paste
        || !in_array($user['_id'], $paste['owners'])) {
            return $res -> withStatus(401);
        }
        $new_owner = $usersStore -> findOneBy(['xid_id', '=', $params->new_owner]);
        if(!$new_owner) {
            return $res -> withStatus(404);
        };
        $paste['owners'][] = $new_owner['_id'];
        $pastesStore -> updateById($paste['_id'], [
           'owners' => $paste['owners']
        ]);
        $new_owner['pastes'][] = $paste['_id'];
        $usersStore -> updateById($new_owner['_id'], [
            'pastes' => $new_owner['pastes']
        ]);
        return $res -> withStatus(200);
    }
    return $res -> withStatus(401);
};