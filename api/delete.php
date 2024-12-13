<?php


if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(200);
    exit();
}


header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');


include_once '../db/Database.php';
include_once '../models/Bookmarks.php';

$database = new Database();

$dbConnection = $database->connect();

$bookmarks = new bookmarks($dbConnection);

$data = json_decode(file_get_contents('php://input'));

if(!$data || !$data->id){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameters id in the json body')

    );
    return;
}


$bookmarks->setId($data->id);
if($bookmarks->delete()){
    echo json_encode(
        array('message' => 'the bookmark deleted')
    );

}else{
    echo json_encode(
    array('message' => 'the bookmark item was not found')
    );
}
