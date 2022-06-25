<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SleekDB\Store;

$notesByUser = function(Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token === null) {
        return $res -> withStatus(401);
    }
    $tokArray = decode_token($params->token);
    if($tokArray['id'] === null) {
        return $res -> withStatus(401);
    }
    $notesStore = new Store(Database::pastes, Database::dir);
    $userNotes = $notesStore -> findBy([['xid_id', '=', $tokArray['id']], ['visibility', '=', 'pri']]);
    $res -> getBody() -> write(json_encode($userNotes));
    return $res -> withStatus(200);
};