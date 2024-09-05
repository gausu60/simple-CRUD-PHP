<?php
require_once 'includes/Database.php';
require_once 'includes/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

// Get user ID from URL
if (isset($_GET['id'])) {
    $user->id = $_GET['id'];

    // Fetch existing user details
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user->id]);
    $userDetails = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Update user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user->username = $_POST['username'];
    $user->email = $_POST['email'];
    $user->age = $_POST['age'];

    if ($user->update()) {
        header("Location: index.php");
        exit();
    } else {
        $message = "Unable to update user.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Update User</title>
</head>
<body>
<div class="container">
    <h2 class="mt-5">Update User</h2>
    <?php if (isset($message)) : ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Form to Update User -->
    <form action="update.php?id=<?php echo $user->id; ?>" method="POST">
        <div class="form-group">
            <label for="username">username</label>
            <input type="text" name="username" id="username" class="form-control" value="<?php echo $userDetails['username']; ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?php echo $userDetails['email']; ?>" required>
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" name="age" id="age" class="form-control" value="<?php echo $userDetails['age']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
</body>
</html>
