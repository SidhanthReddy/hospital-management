<?php
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $_SESSION['cartItems'] = $data;
    echo json_encode(['status' => 'success', 'message' => 'Cart updated']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
}
?>
