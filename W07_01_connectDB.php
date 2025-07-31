<?php
// Connect database ด้วย mysqli
//$host = "localhost";
//$username = "root";
//$password = "";
//$database = "db68_product";

//$conn = new mysqli($host, $username, $password, $database);

//if ($conn->connect_error) {
//    die("Connection failed" . $conn->connect_error);
//} else {
//    echo "Connect successful";
//}
$host = "localhost";
$username = "root";
$password = "";
$database = "db68_product";

$dns = "mysql:host=$host;dbname=$database";
try {
    //$conn = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    $conn = new PDO($dns, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connect successful";

} catch (PDOException $e) {
    echo "Connect failed:" . $e->getMessage();
}
?>