<?php

if($_SERVER['REQUEST_METHOD']!== 'GET'){
    header('Allow: GET');
    http_response_code(405);
    echo json_encode(
        array('message' => 'Method not allowed')
    );
    return;


}


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');


include_once '../db/Database.php';
include_once '../models/Bookmarks.php';

$database = new Database();

$dbConnection = $database->connect();

$bookmarks = new bookmarks($dbConnection);

if(!isset($_GET['id'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing required parameter id.')
    );
    return;
}


$bookmarks->setId($_GET['id']);
if($bookmarks->readOne()){
    $result = array(
        'id' => $bookmarks->getId(),
        'title' => $bookmarks->getTitle(),
        'link' => $bookmarks->getLink(),
        'date_added' => $bookmarks->getDateAdded(),

    );
    echo json_encode($result);

}else{
    http_response_code(404);
    echo json_encode(
        array('message' => 'Error: No such bookmark item')

    );
}