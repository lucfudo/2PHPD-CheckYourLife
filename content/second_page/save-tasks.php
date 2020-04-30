<?php
session_start();
include '../../models/ConfigDao.php';

$owner = session_decode($_SESSION['user_id']);

$requestPayload = file_get_contents("php://input");
$array = json_decode($requestPayload, true);
$title = array_pop($array);
var_dump($array);
var_dump($title);

//$insert = $data_base->prepare("INSERT  INTO lists (list_id, owner, task_name, task_id, task_done, task_trash, task_title)
//                                        VALUE(?, ?, ?, ?, ?, ?, ?)");

$insert = $data_base->prepare("INSERT INTO list (list_id, owner, json, title)
                                         Value(?, ?, ?, ?)");


foreach($array as $row){
    if($row['trash'] == "false") {
        $insert->execute(array(
            NULL,
            $owner,
            $requestPayload,
            $title['title']
        ));
    }
}
