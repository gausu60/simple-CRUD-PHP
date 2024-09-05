<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

// Include database and user model
include_once 'Database.php';
include_once 'User.php';

// Instantiate database and connect
$database = new Database();
$db = $database->getConnection();

// Instantiate user object
$user = new User($db);

$user->username = $_POST['username'];
$user->email = $_POST['email'];

// Create user
if ($user->create()) {
    echo json_encode(array('message' => 'User Created'));
} else {
    echo json_encode(array('message' => 'User Not Created'));
}
?>
