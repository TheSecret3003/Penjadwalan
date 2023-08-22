<?php
$hostmysql="localhost";
$username="root";
$password="";
$database="tugas_akhir";	
$conn=new mysqli($hostmysql, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . mysqli_connect_error());
}
function getConn()
{
    global $conn;
    return $conn;
}
?>