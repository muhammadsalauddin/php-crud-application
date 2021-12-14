<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";


  $conn = new mysqli($servername, $username, $password, $database);
  // set the PDO error mode to exception
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }


  if ($_SERVER["REQUEST_METHOD"] == "POST") {

$id = $_POST['id'];
    // sql to delete a record
    $sql = "DELETE FROM users WHERE id=$id";
      if(!$result = $conn->query($sql)){
  die('There was an error running the query [' . $conn->error . ']');
  }
  else
  {
  $_SESSION["msg"] = '<div class="alert alert-primary" role="alert" id="alert">Record Added successfully</div>';
  header('Location: index.php');
  }

  }



?>
