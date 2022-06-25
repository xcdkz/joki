<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$converterPost = function(Request $req, Response $res) {
    $converter = new Converter();
    $res -> getBody() -> write($converter->convert2Another($req -> getBody()));
    return $res -> withStatus(200);
};

$converter2HTMLPost = function(Request $req, Response $res) {
    $converter = new Converter();
    $res -> getBody() -> write($converter->md2HTML($req -> getBody()));
    return $res -> withStatus(200);
};