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


$result = $bookmarks->readAll();


if(! empty($result)){
    echo json_encode($result);
}else{
    echo json_encode(
        array('message' => 'no bookmark items found')
    );
}