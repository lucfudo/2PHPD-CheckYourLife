<?php
try{
    $data_base = new PDO('mysql:host=localhost; dbname=checkyourlife; charset=utf8', 'root', '');
} catch(Exception $exception){
    die("Connection failed: " . $exception->getMessage());
}