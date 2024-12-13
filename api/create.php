<?php

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods:  POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(200);
    exit();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');

include_once '../db/Database.php';
include_once '../models/Bookmarks.php';

$database = new Database();

$dbConnection = $database->connect();

$bookmarks = new bookmarks($dbConnection);

$data = json_decode(file_get_contents('php://input'), true);


if(!$data || !isset($data['title']) || !isset($data['link'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error missing required parameter title in the json body')
    );
    return;
}

$bookmarks->setTitle($data['title']);
$bookmarks->setLink($data['link']);

if($bookmarks->create()){
    echo json_encode(
        array('message' => 'A bookmarks item was created')

    );
    
}else{
    echo json_encode(
        array('message' => 'Error: no bookmark item was created')

    );
    
}



