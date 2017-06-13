<?php
/* get put post delete*/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../../vendor/autoload.php';

require_once('../models/Car.php');
require_once('../models/Employee.php');
require_once('../models/User.php');
require_once('../models/Location.php');
require_once('../models/Parks.php');


$app = new \Slim\App;
session_start();
//
//  HECHO EN CLASE
//
$app->post('/file', function (Request $request, Response $response){
    // $preJSON = array(   'saved' => false,
    //                     'location' => NULL );
    // $params = $request->getParsedBody();
    $files = $request->getUploadedFiles();

    $stream = $files['file']->getStream();
    $size = $files['file']->getSize();
    $error = $files['file']->getError();
    $filename = $files['file']->getClientFilename();
    $mediaType = $files['file']->getClientMediaType();
    $move = $files['file']->moveTo("/var/www/.temp_upload_php/sarasa.jpg");
    $contentType = $request->getContentType();

    echo('$files');
    vd($files['file']);
    echo('$stream');
    vd($stream);
    echo('$size');
    vd($size);
    echo('$error');
    vd($error);
    echo('$filename');
    vd($filename);
    echo('$mediaType');
    vd($mediaType);
    echo('$_FILES');
    vd($_FILES);
    echo('$move');
    vd($move);
    echo('$contentType');
    vd($contentType);
    die();
});


/*****************************************/
/*  Funciones de manejo de la clase User */
/*****************************************/
$app->get('/user', function (Request $request, Response $response){
    $users = User::getAll();
    var_dump($users);
    $response->getBody()->write("get para get all: ". json_encode($users[0]));
    return $response;
});
$app->get('/user/{user_id}', function (Request $request, Response $response){
    $user_id = $request->getAttribute('user_id');
    $user = User::getFromId($user_id);
    var_dump($user);
    // $response->getBody()->write("Hello, ");
    return $response;
});
$app->put('/user', function (Request $request, Response $response){
    $params = $request->getParsedBody();
    $user = User::getFromId($params['id']);
    $user->setMail($params['mail']);
    $user->setPass($params['pass']);
    $user->setState($params['state']);
    User::updateFromId($user);
    return $response;
});
$app->post('/user', function (Request $request, Response $response){
    $params = $request->getParsedBody();
    $user = new User();
    $user->setMail($params['mail']);
    $user->setPass($params['pass']);
    $user->setState($params['state']);
    $saved_id = $user->save();
    $response->getBody()->write("se inserto con el id: ".$saved_id);
    return $response;
});
$app->delete('/user/{user_id}', function (Request $request, Response $response){
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello, $user_id");
    return $response;
});


$app->run();
