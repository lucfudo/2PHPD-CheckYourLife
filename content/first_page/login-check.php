<?php
session_start();
include '../../models/ConfigDao.php';
$answer = $data_base->query('SELECT * from users');



$nickname = isset($_POST['nickname']) ? $_POST['nickname'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

$statement = $data_base->prepare('SELECT user_id from users where user_name == ?');
$user_id = $statement->execute(array($_POST['nickname']));
$_SESSION['user_id'] = $user_id;

$change = true;
$error_empty = false;
$messages = array();

$flag = 0;

if ( empty($nickname) || empty($password) ) {
    $change = false;
    $error_empty = true;
    $messages[] = 'Fill in all Fields!';
}
else{
    while ($data = $answer->fetch()) {
        if($nickname == $data['user_nickname'] and $password == $data['user_password']){
            $flag = 0;
            $change = true;
            $messages[] = 'Successfully connected!';
            break;
        }
        else{
            $flag = 1;
        }
    }
}
if ($flag){
    $change= false;
    $error_empty = true;
    $messages[] = 'Incorrect username or password.';
}

$_SESSION['user'] = $_POST['nickname'];

echo json_encode(
    array(
        'change' => $change,
        'error' => $error_empty,
        'messages' => $messages
    )
);