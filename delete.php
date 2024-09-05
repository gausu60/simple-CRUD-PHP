<?php
require_once 'includes/Database.php';
require_once 'includes/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// Get user ID from URL
if (isset($_GET['id'])) {
    $user->id = $_GET['id'];

    // Delete user
    if ($user->delete()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Unable to delete user.";
    }
}
?>
