<?php
include "db.php";
$user_id = $_GET['user_id'];
$result = $conn->query("SELECT * FROM messages WHERE user_id = $user_id ORDER BY id ASC");
$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}
echo json_encode($data);
?>