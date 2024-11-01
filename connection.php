<?php

$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'crud_app';

$conn = new mysqli($host, $user, $password, $dbname);

if($conn->connect_error){
    die("connection failed: " . $conn->connect_error);
}
