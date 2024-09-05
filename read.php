<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Include database and user model
include_once 'Database.php';
include_once 'User.php';

// Instantiate database and connect
$database = new Database();
$db = $database->getConnection();

// Instantiate user object
$user = new User($db);

// User query
$stmt = $user->read();
$num = $stmt->rowCount();

// Check if any users
if($num > 0) {
    $users_arr = array();
    $users_arr['data'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_item = array(
            'id' => $id,
            'username' => $username,
            'email' => $email,
            'created_at' => $created_at
        );

        array_push($users_arr['data'], $user_item);
    }

    echo json_encode($users_arr);
} else {
    echo json_encode(array('message' => 'No Users Found'));
}
?>
