<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$aboutGet = function (Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/about/about.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
};
