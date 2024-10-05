<?php 

$host = 'localhost';
$user = 'root';
$pass = '';
$database = 'kolokvijumi';

$conn = new mysqli($host,$user,$pass,$database);

if ($conn->connect_errno) {
    echo "Neuspsno povezivanje sa bazom";
}


?>