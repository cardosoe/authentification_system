<?php


//host
$host = "localhost";

//database name
$dbname = "auth_sys";

//database user
$dbuser = "root";

//database password
$dbpass = "";

//create connection
$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);

//check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// } else {
//     echo "Connected successfully";
// }