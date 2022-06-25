<?php
include_once 'server/database.php';
include_once 'server/tokens.php';
include_once 'server/hcaptcha.php';
include_once 'server/mdconverter.php';
include_once 'server/routes/register.php';
include_once 'server/routes/login.php';
include_once 'server/routes/paste.php';
include_once 'server/routes/about.php';
include_once 'server/routes/contact.php';
include_once 'server/routes/404.php';
include_once 'server/routes/dashboard.php';
include_once 'server/routes/notes.php';
include_once 'server/routes/converter.php';
include_once 'server/routes/search.php';
include_once 'server/routes/admin.php';

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\AppFactory;
use SleekDB\Store;

$app = AppFactory::create();

$app -> addRoutingMiddleware();

$app -> addErrorMiddleware(true, true, true);

$app -> options('/{routes:.+}', function ($request, $response) {
    return $response;
});

$app -> add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', 'http://'.$_SERVER['SERVER_NAME'])
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app -> get('/', function (Request $req, Response $res) {
    include('client/html/navbar.php');
    include('client/html/index/content.php');
    include('client/html/footer.php');
    return $res -> withStatus(200);
});

$app -> options('/', function (Request $req, Response $res) {
    $params = json_decode($req->getBody());
    if($params->token === null) {
        return $res -> withStatus(401);
    }
    $tokArray = decode_token($params->token);
    $usersStore = new Store(Database::users, Database::dir);
    $userInStore = $usersStore -> findOneBy(['xid_id', '=', $tokArray['id']]);
    if($userInStore === null) {
        return $res -> withStatus(401);
    }
    $user = [
        'username' => $userInStore['username'],
        'xid_id' => $userInStore['xid_id'],
        'role' => $userInStore['role']
    ];
    $res -> getBody() -> write(json_encode($user));
    return $res -> withStatus(200);
});

$app -> get('/404', $notFoundPage);

$app -> post('/paste', $pastePublicPost);
$app -> get('/paste/public', $pastePublicGet);
$app -> post('/paste/public/{id}', $pasteGetWithId);
$app -> get('/paste/{id}', $pasteGetWithIdPage);

$app -> get('/register', $registerGet);
$app -> post('/register', $registerPost);

$app -> get('/login', $loginGet);
$app -> post('/login', $loginPost);

$app -> get('/about', $aboutGet);

$app -> get('/contact', $contactGet);

$app -> get('/dashboard', $dashboardGetPage);
$app -> get('/dashboard/edit', $dashboardEditPastePage);
$app -> post('/dashboard/pastes', $dashboardGetPastes);
$app -> post('/dashboard/paste/remove/{id}', $dashboardRemovePaste);
$app -> post('/dashboard/edit', $dashboardEditGetPaste);
$app -> post('/dashboard/edit/update', $dashboardEditSubmitPaste);
$app -> post('/dashboard/edit/addowner', $dashboardEditAddOwner);

$app -> get('/user/notes', $notesByUser);

$app -> post('/converter', $converterPost);
$app -> post('/converter/final', $converter2HTMLPost);

$app -> get('/search', $searchGetPage);
$app -> get('/search/pubpastes', $searchGetPastes);

$app -> get('/admin/panel', $adminPanelPage);
$app -> post('/admin/users', $adminGetUsers);
$app -> post('/admin/makeadmin', $adminMakeAdmin);
$app -> post('/admin/removeuser', $adminRemoveUser);
$app -> post('/admin/degradeuser', $adminDegradeUser);

$app -> map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request) {
    throw new HttpNotFoundException($request);
});

$app -> run();
