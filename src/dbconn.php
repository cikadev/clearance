<?php
require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::create(__DIR__ . "/../");
$dotenv->load();

$servername = getenv("DATABASE_HOST");
$username = getenv("DATABASE_USERNAME");
$password = getenv("DATABASE_PASSWORD");
$dbname = getenv("DATABASE_NAME");

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 //   echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
