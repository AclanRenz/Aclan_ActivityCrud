<?php 
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'act01';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

?>