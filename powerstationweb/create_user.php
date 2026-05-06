<?php
include "db.php";
$username = "User_" . rand(1000,9999);
$conn->query("INSERT INTO users (username) VALUES ('$username')");
$user_id = $conn->insert_id;
echo json_encode([
  "user_id" => $user_id,
  "username" => $username
]);
?>