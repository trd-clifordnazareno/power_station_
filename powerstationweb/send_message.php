<?php
include "db.php";

// GET DATA
$user_id = $_POST['user_id'];
$message = $_POST['message'];
$sender  = $_POST['sender'];

// 🔍 CHECK IF FIRST MESSAGE OF USER
$check = $conn->prepare("SELECT COUNT(*) as total FROM messages WHERE user_id = ?");
$check->bind_param("i", $user_id);
$check->execute();

$result = $check->get_result();
$row = $result->fetch_assoc();

$isFirstMessage = ($row['total'] == 0);

// 💬 INSERT USER MESSAGE
$stmt = $conn->prepare("INSERT INTO messages (user_id, message, sender) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $message, $sender);
$stmt->execute();

// 🤖 AUTO WELCOME (ONLY FIRST MESSAGE FROM USER)
if ($isFirstMessage && $sender === "user") {

    $welcomeMessage = "👋 Welcome! Thank you for contacting us.\nHow can we assist you today?";

    $stmt2 = $conn->prepare("INSERT INTO messages (user_id, message, sender) VALUES (?, ?, 'admin')");
    $stmt2->bind_param("is", $user_id, $welcomeMessage);
    $stmt2->execute();
}

// RESPONSE
echo json_encode([
  "status" => "success"
]);
?>