<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$searchGetPage = function(Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/search/search.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};

$searchGetPastes = function(Request $req, Response $res) {
    $pastesStore = new Store(Database::pastes, Database::dir);
    $pastes = $pastesStore->findBy(['visibility', '=', 'pub']);
    $res -> getBody() -> write('[');
    $str = '';
    foreach($pastes as $p) {
        $str .= json_encode([
            'title' => $p['title'],
            'creator' => $p['creator_username'],
            'url' => 'http://' . $_SERVER['SERVER_NAME'] . '/paste/' . $p['xid_id'],
        ]) . ',';
    }
    $str = substr($str, 0, -1) . ']';
    $res -> getBody() -> write($str);
    return $res -> withStatus(200);
};